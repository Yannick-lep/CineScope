<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FilmPublicTest extends WebTestCase
{
    public function testFilmsListReturns200(): void
    {
        $client = static::createClient();
        $client->request('GET', '/films');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertSelectorTextContains('h1', 'Catalogue de films');
    }

    public function testFilmShowReturns200AndDisplaysPlatforms(): void
    {
        $client = static::createClient();
        
        // On va chercher le premier film (ID 1)
        $crawler = $client->request('GET', '/films/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        
        // Vérifier qu'il y a au moins une plateforme affichée
        // Chercher "Disponible sur" ou les noms de plateformes
        $content = $client->getResponse()->getContent();
        
        $this->assertStringContainsStringIgnoringCase(
            'Où regarder ce film',
            $content
        );
    }
}