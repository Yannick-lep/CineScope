<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityTest extends WebTestCase
{
    public function testAdminFilmsRedirectsToLoginWhenNotAuthenticated(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/films');

        // Doit rediriger vers login (302)
        $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects('/login');
    }

    public function testAdminFilmsReturns403ForRoleUser(): void
    {
        $client = static::createClient();
        
        // Trouver un user avec ROLE_USER
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy(['email' => 'user@cinescope.fr']);

        // Simuler la connexion
        $client->loginUser($user);
        
        $client->request('GET', '/admin/films');

        // Doit retourner 403 (Forbidden)
        $this->assertResponseStatusCodeSame(403);
    }

    public function testAdminFilmsReturns200ForRoleAdmin(): void
    {
        $client = static::createClient();
        
        // Trouver un user avec ROLE_ADMIN
        $userRepository = static::getContainer()->get(UserRepository::class);
        $admin = $userRepository->findOneBy(['email' => 'admin@cinescope.fr']);

        // Simuler la connexion
        $client->loginUser($admin);
        
        $client->request('GET', '/admin/films');

        // Doit retourner 200 (OK)
        $this->assertResponseStatusCodeSame(200);
    }
}
