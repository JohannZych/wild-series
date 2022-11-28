<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    public const PROGRAM = [
        ['title'  =>'Walking Dead','synopsis' => 'Des zombies envahissent la terre', 'category' => 'category_Action'],
        ['title'  =>'La 7eme Compagnie','synopsis' => 'Des militaires déjouent les Allemands', 'category' => 'category_Aventure'],
        ['title'  =>'Toy Story','synopsis' => 'Des jouets vivent leurs vies!', 'category' => 'category_Animation'],
        ['title'  =>'Star Wars','synopsis' => 'De la SF, de la vraie', 'category' => 'category_Fantastique'],
        ['title'  =>'Exorciste','synopsis' => 'Démons et prêtres', 'category' => 'category_Horreur'],
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::PROGRAM as $programMovie) {
            $program = new Program();
            $program->setTitle($programMovie['title']);
            $program->setSynopsis($programMovie['synopsis']);
            $program->setCategory($this->getReference($programMovie['category']));
            $manager->persist($program);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }


}