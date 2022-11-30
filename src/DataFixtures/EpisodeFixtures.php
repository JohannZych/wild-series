<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Episode;
use Faker\Factory;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            ProgramFixtures::class,
        ];
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $episode = new Episode();
            //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
            $episode->setNumber($faker->numberBetween(1, 10));
            $episode->setTitle($faker->sentence(3));
            $episode->setSynopsis($faker->paragraphs(2, true));
            $episode->setSeason($this->getReference('season_' . $faker->numberBetween(0, 5)));

            $manager->persist($episode);
        }

        $manager->flush();
    }
}