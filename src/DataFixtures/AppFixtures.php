<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Platforme;
use App\Entity\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // ========== USERS ==========
        
        // Admin
        $admin = new User();
        $admin->setEmail('admin@cinescope.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'admin123')
        );
        $admin->setAvatar('https://ui-avatars.com/api/?name=Admin&background=dc2626&color=fff');
        $manager->persist($admin);

        // User normal
        $user = new User();
        $user->setEmail('user@cinescope.fr');
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, 'user123')
        );
        $user->setAvatar('https://ui-avatars.com/api/?name=User&background=3b82f6&color=fff');
        $manager->persist($user);

        // ========== PLATEFORMES ==========
        
        $netflix = new Platforme();
        $netflix->setName('Netflix');
        $netflix->setUrl('https://www.netflix.com');
        $netflix->setLogo('https://images.justwatch.com/icon/430997/s100/netflix.webp');
        $manager->persist($netflix);

        $prime = new Platforme();
        $prime->setName('Prime Video');
        $prime->setUrl('https://www.primevideo.com');
        $prime->setLogo('https://images.justwatch.com/icon/52449861/s100/amazon-prime-video.webp');
        $manager->persist($prime);

        $disney = new Platforme();
        $disney->setName('Disney+');
        $disney->setUrl('https://www.disneyplus.com');
        $disney->setLogo('https://images.justwatch.com/icon/147638351/s100/disney-plus.webp');
        $manager->persist($disney);

        $canal = new Platforme();
        $canal->setName('Canal+');
        $canal->setUrl('https://www.canalplus.com');
        $canal->setLogo('https://images.justwatch.com/icon/820542/s100/canal.webp');
        $manager->persist($canal);

        // ========== FILMS ==========
        
        $inception = new Film();
        $inception->setTitle('Inception');
        $inception->setSynopsis('Dom Cobb est un voleur expérimenté, le meilleur dans l\'art dangereux de l\'extraction, voler les secrets les plus intimes enfouis au plus profond du subconscient durant une phase de rêve.');
        $inception->setReleaseYear(2010);
        $inception->addPlatforme($netflix);
        $inception->addPlatforme($prime);
        $manager->persist($inception);

        $interstellar = new Film();
        $interstellar->setTitle('Interstellar');
        $interstellar->setSynopsis('Dans un futur proche, face à une Terre exsangue, un groupe d\'explorateurs utilise un vaisseau interstellaire pour franchir un trou de ver permettant de parcourir des distances jusque-là infranchissables.');
        $interstellar->setReleaseYear(2014);
        $interstellar->addPlatforme($prime);
        $interstellar->addPlatforme($canal);
        $manager->persist($interstellar);

        $mandalorian = new Film();
        $mandalorian->setTitle('The Mandalorian - Saison 1');
        $mandalorian->setSynopsis('Après la chute de l\'Empire et avant l\'émergence du Premier Ordre, un chasseur de primes solitaire opère dans les confins de la galaxie.');
        $mandalorian->setReleaseYear(2019);
        $mandalorian->addPlatforme($disney);
        $manager->persist($mandalorian);

        $oppenheimer = new Film();
        $oppenheimer->setTitle('Oppenheimer');
        $oppenheimer->setSynopsis('Le film raconte l\'histoire du physicien J. Robert Oppenheimer et son rôle dans le développement de la bombe atomique.');
        $oppenheimer->setReleaseYear(2023);
        $oppenheimer->addPlatforme($prime);
        $oppenheimer->addPlatforme($canal);
        $manager->persist($oppenheimer);

        $dune = new Film();
        $dune->setTitle('Dune');
        $dune->setSynopsis('L\'histoire de Paul Atreides, jeune homme aussi doué que brillant, voué à connaître un destin hors du commun qui le dépasse totalement.');
        $dune->setReleaseYear(2021);
        $dune->addPlatforme($netflix);
        $dune->addPlatforme($prime);
        $dune->addPlatforme($canal);
        $manager->persist($dune);

        $parasite = new Film();
        $parasite->setTitle('Parasite');
        $parasite->setSynopsis('Toute la famille de Ki-taek est au chômage. Elle s\'intéresse particulièrement au train de vie de la richissime famille Park.');
        $parasite->setReleaseYear(2019);
        $parasite->addPlatforme($netflix);
        $manager->persist($parasite);

        $manager->flush();

        echo "✅ Fixtures chargées avec succès !\n";
        echo "👤 Admin: admin@cinescope.fr / admin123\n";
        echo "👤 User: user@cinescope.fr / user123\n";
    }
}
