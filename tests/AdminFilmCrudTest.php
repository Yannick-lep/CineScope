<?php

namespace App\Tests\Controller;

use App\Entity\Film;
use App\Repository\FilmRepository;
use App\Repository\PlatformeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminFilmCrudTest extends WebTestCase
{
    public function testAdminCanCreateFilmWithPlatforms(): void
    {
        $client = static::createClient();
        
        // 1. Se connecter en tant qu'admin
        $userRepository = static::getContainer()->get(UserRepository::class);
        $admin = $userRepository->findOneBy(['email' => 'admin@cinescope.fr']);
        $client->loginUser($admin);
        
        // 2. Aller sur la page de création
        $crawler = $client->request('GET', '/admin/films/new');
        $this->assertResponseIsSuccessful();
        
        // 3. Récupérer les plateformes
        $plateformeRepository = static::getContainer()->get(PlatformeRepository::class);
        $netflix = $plateformeRepository->findOneBy(['name' => 'Netflix']);
        $prime = $plateformeRepository->findOneBy(['name' => 'Prime Video']);
        
        // 4. Remplir et soumettre le formulaire
        $form = $crawler->selectButton('Save')->form([
            'film[title]' => 'Film de Test Automatique',
            'film[synopsis]' => 'Ceci est un synopsis de test automatique',
            'film[releaseYear]' => 2025,
            'film[platformes]' => [$netflix->getId(), $prime->getId()],
        ]);
        
        $client->submit($form);
        
        // 5. Vérifier la redirection
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        
        // 6. Vérifier que le film est en base
        $filmRepository = static::getContainer()->get(FilmRepository::class);
        $film = $filmRepository->findOneBy(['title' => 'Film de Test Automatique']);
        
        $this->assertNotNull($film, 'Le film devrait être créé en base');
        $this->assertEquals('Ceci est un synopsis de test automatique', $film->getSynopsis());
        $this->assertEquals(2025, $film->getReleaseYear());
        
        // 7. Vérifier les relations avec les plateformes
        $this->assertCount(2, $film->getPlatformes(), 'Le film devrait avoir 2 plateformes');
        
        $platformeNames = [];
        foreach ($film->getPlatformes() as $platforme) {
            $platformeNames[] = $platforme->getName();
        }
        
        $this->assertContains('Netflix', $platformeNames);
        $this->assertContains('Prime Video', $platformeNames);
        
        // 8. Nettoyage : supprimer le film de test
        $entityManager = static::getContainer()->get('doctrine')->getManager();
        $entityManager->remove($film);
        $entityManager->flush();
    }
}