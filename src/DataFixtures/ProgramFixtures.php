<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker= Factory::create();
        for($i=0;$i<25;$i++) {
            $program = new Program();
            $program->setTitle($faker->sentence(2));
            $program->setSynopsis($faker->paragraph(3, true));
            $program->setCategory($this->getReference('category_' . $faker-> numberBetween(0,4)));
            $manager->persist($program);
            $this->addReference('program_' . $i, $program);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }


}