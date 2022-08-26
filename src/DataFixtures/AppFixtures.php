<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\ImageAnnonce;
use App\Entity\SousCategorie;
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
        $faker = Factory::create('fr_FR');

        $user = new User;
        $user->setEmail($faker->email())
            ->setPrenom($faker->firstName())
            ->setNom($faker->lastName());

        $password = $this->hasher->hashPassword($user, 'password');
        $user->setPassword($password);
        $manager->persist($user);

        //Les categories 
        $categories = [
            "Vehicules", "Immobilier", "Vetements",
            "Santé, beauté, cosmétiques",
            "Multimédia", "Foyer", "Sports", "Offres d'Emploi"
        ];
        //Les categories et ses sous categories
        for ($i = 0; $i < 8; $i++) {
            $categorie = new Categorie;
            $categorie->setLibelle($categories[$i]);
            $manager->persist($categorie);
            if ($i === 0) {
                //Les vehicules
                $vehicules = [
                    'Voitures', 'Scooters & Motos',
                    'Location de voiture', 'Equipement & pieces',
                    'Bateaux'
                ];
                for ($j = 0; $j < 5; $j++) {
                    $sous_categorie = new SousCategorie;
                    $sous_categorie->setCategorie($categorie)
                        ->setLibelle($vehicules[$j]);
                    $manager->persist($sous_categorie);
                    //Les annonces
                    for ($k = 0; $k < 5; $k++) {
                        $annonce = new Annonce;
                        $annonce->setUser($user)
                            ->setSousCategorie($sous_categorie)
                            ->setLibelleAnnonce($faker->company())
                            ->setDescription($faker->paragraph())
                            ->setPrix($faker->randomNumber(3))
                            ->setSlug($faker->slug())
                            ->setIsCime(false)
                            ->setIsPaye(true)
                            ->setIsUptodate(true)
                            ->setIsVendu(false)
                            ->setIsPro(false);
                        $manager->persist($annonce);
                        //Les images
                        for ($l = 0; $l < 4; $l++) {
                            $image = new ImageAnnonce;
                            $image->setArticle($annonce)
                                ->setImageName('assets/img/product/product1.jpg');
                            $manager->persist($image);
                        }
                        //les commentaires
                        for ($l = 0; $l < 3; $l++) {
                            $commentaire = new Commentaire;
                            $commentaire->setAnnonce($annonce)
                                ->setUser($user)
                                ->setContent($faker->sentence());
                            $manager->persist($commentaire);
                        }
                    }
                }
            }
            if ($i === 1) {
                //Les vehicules
                $immobiliers = [
                    'Appartements à louer', 'Terrains à vendre',
                    'Maisons à vendre', 'Maisons à louer',
                    'Appartements meublés'
                ];
                for ($j = 0; $j < 5; $j++) {
                    $sous_categorie = new SousCategorie;
                    $sous_categorie->setCategorie($categorie)
                        ->setLibelle($immobiliers[$j]);
                    $manager->persist($sous_categorie);
                    //Les annonces
                    for ($k = 0; $k < 5; $k++) {
                        $annonce = new Annonce;
                        $annonce->setUser($user)
                            ->setSousCategorie($sous_categorie)
                            ->setLibelleAnnonce($faker->company())
                            ->setDescription($faker->paragraph())
                            ->setPrix($faker->randomNumber(3))
                            ->setSlug($faker->slug())
                            ->setIsCime(false)
                            ->setIsPaye(true)
                            ->setIsUptodate(true)
                            ->setIsVendu(false)
                            ->setIsPro(false);
                        $manager->persist($annonce);
                        //Les images
                        for ($l = 0; $l < 4; $l++) {
                            $image = new ImageAnnonce;
                            $image->setArticle($annonce)
                                ->setImageName('assets/img/product/product1.jpg');
                            $manager->persist($image);
                        }
                        //les commentaires
                        for ($l = 0; $l < 3; $l++) {
                            $commentaire = new Commentaire;
                            $commentaire->setAnnonce($annonce)
                                ->setUser($user)
                                ->setContent($faker->sentence());
                            $manager->persist($commentaire);
                        }
                    }
                }
            }
            if ($i === 2) {
                //Le Mode
                $modes = [
                    'Vêtements pour femme', 'Chaussures pour femmme',
                    'Vêtements pour homme', 'Chaussures pour homme',
                    'Sacs à main & Foulards',
                ];
                for ($j = 0; $j < 5; $j++) {
                    $sous_categorie = new SousCategorie;
                    $sous_categorie->setCategorie($categorie)
                        ->setLibelle($modes[$j]);
                    $manager->persist($sous_categorie);
                    //Les annonces
                    for ($k = 0; $k < 5; $k++) {
                        $annonce = new Annonce;
                        $annonce->setUser($user)
                            ->setSousCategorie($sous_categorie)
                            ->setLibelleAnnonce($faker->company())
                            ->setDescription($faker->paragraph())
                            ->setPrix($faker->randomNumber(3))
                            ->setSlug($faker->slug())
                            ->setIsCime(false)
                            ->setIsPaye(true)
                            ->setIsUptodate(true)
                            ->setIsVendu(false)
                            ->setIsPro(false);
                        $manager->persist($annonce);
                        //Les images
                        for ($l = 0; $l < 4; $l++) {
                            $image = new ImageAnnonce;
                            $image->setArticle($annonce)
                                ->setImageName('assets/img/product/product1.jpg');
                            $manager->persist($image);
                        }
                        //les commentaires
                        for ($l = 0; $l < 3; $l++) {
                            $commentaire = new Commentaire;
                            $commentaire->setAnnonce($annonce)
                                ->setUser($user)
                                ->setContent($faker->sentence());
                            $manager->persist($commentaire);
                        }
                    }
                }
            }
            if ($i === 3) {
                //Santé, beauté, cosmétiques
                $santés = [
                    'Parfums', 'Bijoux & montres',
                    'Produits cosmétiques', 'cosmétiques bio',
                ];
                for ($j = 0; $j < 4; $j++) {
                    $sous_categorie = new SousCategorie;
                    $sous_categorie->setCategorie($categorie)
                        ->setLibelle($santés[$j]);
                    $manager->persist($sous_categorie);
                    //Les annonces
                    for ($k = 0; $k < 5; $k++) {
                        $annonce = new Annonce;
                        $annonce->setUser($user)
                            ->setSousCategorie($sous_categorie)
                            ->setLibelleAnnonce($faker->company())
                            ->setDescription($faker->paragraph())
                            ->setPrix($faker->randomNumber(4))
                            ->setSlug($faker->slug())
                            ->setIsCime(false)
                            ->setIsPaye(true)
                            ->setIsUptodate(true)
                            ->setIsVendu(false)
                            ->setIsPro(false);
                        $manager->persist($annonce);
                        //Les images
                        for ($l = 0; $l < 4; $l++) {
                            $image = new ImageAnnonce;
                            $image->setArticle($annonce)
                                ->setImageName('assets/img/product/product1.jpg');
                            $manager->persist($image);
                        }
                        //les commentaires
                        for ($l = 0; $l < 3; $l++) {
                            $commentaire = new Commentaire;
                            $commentaire->setAnnonce($annonce)
                                ->setUser($user)
                                ->setContent($faker->sentence());
                            $manager->persist($commentaire);
                        }
                    }
                }
            }

            if ($i === 4) {
                //Multimédia
                $multimédia = [
                    'Ordinateurs', 'Téléphones',
                    'Accessoires', 'Jeux video & consoles',
                    'TV & home cinéma',
                ];
                for ($j = 0; $j < 5; $j++) {
                    $sous_categorie = new SousCategorie;
                    $sous_categorie->setCategorie($categorie)
                        ->setLibelle($multimédia[$j]);
                    $manager->persist($sous_categorie);
                    //Les annonces
                    for ($k = 0; $k < 5; $k++) {
                        $annonce = new Annonce;
                        $annonce->setUser($user)
                            ->setSousCategorie($sous_categorie)
                            ->setLibelleAnnonce($faker->company())
                            ->setDescription($faker->paragraph())
                            ->setPrix($faker->randomNumber(3))
                            ->setSlug($faker->slug())
                            ->setIsCime(false)
                            ->setIsPaye(true)
                            ->setIsUptodate(true)
                            ->setIsVendu(false)
                            ->setIsPro(false);
                        $manager->persist($annonce);
                        //Les images
                        for ($l = 0; $l < 4; $l++) {
                            $image = new ImageAnnonce;
                            $image->setArticle($annonce)
                                ->setImageName('assets/img/product/product1.jpg');
                            $manager->persist($image);
                        }
                        //les commentaires
                        for ($l = 0; $l < 3; $l++) {
                            $commentaire = new Commentaire;
                            $commentaire->setAnnonce($annonce)
                                ->setUser($user)
                                ->setContent($faker->sentence());
                            $manager->persist($commentaire);
                        }
                    }
                }
            }
            if ($i === 5) {
                //foyer
                $foyers = [
                    'Mobilier, Décoration', 'Electromenager',
                    'Linge de maison', 'Vaisselle',
                    'Jardinage, bricolage'
                ];
                for ($j = 0; $j < 5; $j++) {
                    $sous_categorie = new SousCategorie;
                    $sous_categorie->setCategorie($categorie)
                        ->setLibelle($foyers[$j]);
                    $manager->persist($sous_categorie);
                    //Les annonces
                    for ($k = 0; $k < 5; $k++) {
                        $annonce = new Annonce;
                        $annonce->setUser($user)
                            ->setSousCategorie($sous_categorie)
                            ->setLibelleAnnonce($faker->company())
                            ->setDescription($faker->paragraph())
                            ->setPrix($faker->randomNumber(3))
                            ->setSlug($faker->slug())
                            ->setIsCime(false)
                            ->setIsPaye(true)
                            ->setIsUptodate(true)
                            ->setIsVendu(false)
                            ->setIsPro(false);
                        $manager->persist($annonce);
                        //Les images
                        for ($l = 0; $l < 4; $l++) {
                            $image = new ImageAnnonce;
                            $image->setArticle($annonce)
                                ->setImageName('assets/img/product/product1.jpg');
                            $manager->persist($image);
                        }
                        //les commentaires
                        for ($l = 0; $l < 3; $l++) {
                            $commentaire = new Commentaire;
                            $commentaire->setAnnonce($annonce)
                                ->setUser($user)
                                ->setContent($faker->sentence());
                            $manager->persist($commentaire);
                        }
                    }
                }
            }
            if ($i === 6) {
                //sports
                $sports = [
                    'Materiels de sport', 'Vêtements',
                    'Chaussures de sport', 'Autres accessoires'
                ];
                for ($j = 0; $j < 4; $j++) {
                    $sous_categorie = new SousCategorie;
                    $sous_categorie->setCategorie($categorie)
                        ->setLibelle($sports[$j]);
                    $manager->persist($sous_categorie);
                    //Les annonces
                    for ($k = 0; $k < 5; $k++) {
                        $annonce = new Annonce;
                        $annonce->setUser($user)
                            ->setSousCategorie($sous_categorie)
                            ->setLibelleAnnonce($faker->company())
                            ->setDescription($faker->paragraph())
                            ->setPrix($faker->randomNumber(3))
                            ->setSlug($faker->slug())
                            ->setIsCime(false)
                            ->setIsPaye(true)
                            ->setIsUptodate(true)
                            ->setIsVendu(false)
                            ->setIsPro(true);
                        $manager->persist($annonce);
                        //Les images
                        for ($l = 0; $l < 4; $l++) {
                            $image = new ImageAnnonce;
                            $image->setArticle($annonce)
                                ->setImageName('assets/img/product/product1.jpg');
                            $manager->persist($image);
                        }
                        //les commentaires
                        for ($l = 0; $l < 3; $l++) {
                            $commentaire = new Commentaire;
                            $commentaire->setAnnonce($annonce)
                                ->setUser($user)
                                ->setContent($faker->sentence());
                            $manager->persist($commentaire);
                        }
                    }
                }
            }
            if ($i === 7) {
                //Emplois
                $emplois = [
                    'Stages', 'CDD',
                    'CDI'
                ];
                for ($j = 0; $j < 3; $j++) {
                    $sous_categorie = new SousCategorie;
                    $sous_categorie->setCategorie($categorie)
                        ->setLibelle($emplois[$j]);
                    $manager->persist($sous_categorie);
                    //Les annonces
                    for ($k = 0; $k < 5; $k++) {
                        $annonce = new Annonce;
                        $annonce->setUser($user)
                            ->setSousCategorie($sous_categorie)
                            ->setLibelleAnnonce($faker->company())
                            ->setDescription($faker->paragraph())
                            ->setPrix($faker->randomNumber(3))
                            ->setSlug($faker->slug())
                            ->setIsCime(false)
                            ->setIsPaye(true)
                            ->setIsUptodate(true)
                            ->setIsVendu(false)
                            ->setIsPro(false);
                        $manager->persist($annonce);
                        //Les images
                        for ($l = 0; $l < 4; $l++) {
                            $image = new ImageAnnonce;
                            $image->setArticle($annonce)
                                ->setImageName('assets/img/product/product1.jpg');
                            $manager->persist($image);
                        }
                        //les commentaires
                        for ($l = 0; $l < 3; $l++) {
                            $commentaire = new Commentaire;
                            $commentaire->setAnnonce($annonce)
                                ->setUser($user)
                                ->setContent($faker->sentence());
                            $manager->persist($commentaire);
                        }
                    }
                }
            }
            $manager->flush();
        }

        // $user = new User;
        // $user->setEmail('user@test.com')
        //     ->setPrenom($faker->firstName())
        //     ->setNom($faker->lastName());

        // $password = $this->hasher->hashPassword($user, 'password');
        // $user->setPassword($password);
        // $manager->persist($user);
        // $manager->flush();
    }
}
