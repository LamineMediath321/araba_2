<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('sn_SN');

        $user = new User;
        $user->setEmail('user@test.com')
            ->setPrenom($faker->firstName())
            ->setNom($faker->lastName())
            ->setTelephone($faker->phoneNumber())
            ->setAdresse($faker->text());

        $password = $this->hasher->hashPassword($user, 'password');
        $user->setPassword($password);

        $manager->persist($user);

        // for ($i = 0; $i < 10; $i++) {
        //     $annonce = new Annonce;
        //     $annonce->setLibelleAnnonce($faker->words(3, true))
        //         ->setDescription($faker->text(350))
        //         ->setLieuDeVente($faker->city . " " . $faker->us_state_abbr . " " . $faker->us_zip_code)
        //         ->setPrix($faker->price())
        //         ->setUser($user)
        //         ->setLienVideo($faker->link)
        //         ->setSousCategorie($sousCategorie);
        // }

        $manager->flush();
    }
}
