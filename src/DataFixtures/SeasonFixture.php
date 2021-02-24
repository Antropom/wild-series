<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeasonFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 6; $i++) {
            for ($j = 1; $j <= 4; $j++) {
                $season = new Season();
                $season->setNumber($j);
                $season->setDescription($faker->paragraph);
                $season->setYear($faker->year);
                $season->setProgram($this->getReference('program_' . $i));
                $manager->persist($season);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
       return [ProgramFixtures::class];
    }
}
