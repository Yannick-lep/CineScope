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
        
        // 3. Remplir le formulaire
        $plateformeRepository = static::getContainer()->get(PlatformeRepository::class);
        $netflix = $plateformeRepository->findOneBy(['name' => 'Netflix']);
        $prime = $plateformeRepository->findOneBy(['name' => 'Prime Video']);
        
        $form = $crawler->selectButton('Enregistrer')->form([
            'film[title]' => 'Film de Test',
            'film[synopsis]' => 'Ceci est un synopsis de test',
            'film[releaseYear]' => 2024,
            'film[platformes]' => [$netflix->getId(), $prime->getId()],
        ]);
        
        // 4. Soumettre le formulaire
        $client->submit($form);
        
        // 5. Vérifier la redirection
        $this->assertResponseRedirects();
        $client->followRedirect();
        
        // 6. Vérifier que le film est en base
        $filmRepository = static::getContainer()->get(FilmRepository::class);
        $film = $filmRepository->findOneBy(['title' => 'Film de Test']);
        
        $this->assertNotNull($film);
        $this->assertEquals('Ceci est un synopsis de test', $film->getSynopsis());
        $this->assertEquals(2024, $film->getReleaseYear());
        
        // 7. Vérifier les relations avec les plateformes
        $this->assertCount(2, $film->getPlatformes());
        $platformeNames = array_map(
            fn($p) => $p->getName(),
            $film->getPlatformes()->toArray()
        );
        $this->assertContains('Netflix', $platformeNames);
        $this->assertContains('Prime Video', $platformeNames);
    }
}
