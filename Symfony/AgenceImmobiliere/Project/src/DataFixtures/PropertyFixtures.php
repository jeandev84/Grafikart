<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


/**
 * Class PropertyFixtures
 * @package App\DataFixtures
*/
class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        # Instancier Faker
        $faker = Factory::create('fr_FR');

        # Ajout de donnees
        for($i = 0; $i < 100; $i++)
        {
            $property = new Property();
            # Generer 3 mots
            $property->setTitle($faker->words(3, true))
                ->setDescription($faker->sentences(3, true))
                ->setSurface($faker->numberBetween(20, 350)) // surface entre 20 et 350 m2
                ->setRooms($faker->numberBetween(2, 10))  //entre 2 et 10 pieces
                ->setBedrooms($faker->numberBetween(1, 9))
                ->setFloor($faker->numberBetween(0, 15)) // 0 : rais de chaussee et 15 - ieme etage
                ->setPrice($faker->numberBetween(100000, 1000000))
                ->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1))
                ->setCity($faker->city)
                ->setAddress($faker->address)
                ->setPostalCode($faker->postcode)
                ->setSold(false);

            # persit permet de garder en memoire l'ensemble des proprietes je veux initialiser
            # affecte les valeurs aux proprietes
            $manager->persist($property);
        }

        $manager->flush();
    }
}
