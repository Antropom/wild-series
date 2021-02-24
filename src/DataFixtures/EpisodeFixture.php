<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 24; $i++) {
            for ($j = 1; $j <= 12; $j++) {
                $episode = new Episode();
                $episode->setTitle($faker->sentence);
                $episode->setNumber($j);
                $episode->setSynopsis($faker->paragraph);
                $episode->setSeason($this->getReference('season_' . $i));
                $manager->persist($episode);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [SeasonFixture::class];
    }
}
