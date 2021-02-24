<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'Andrew Lincoln' => ['program_0', 'program_5'],
        'Norman Reedus' => ['program_0'],
        'Lauren Cohan' => ['program_0'],
        'Danai Gurira' => ['program_0']
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $name => $programs) {
            $actor = new Actor();
            $actor->setName($name);
            foreach ($programs as $program) {
                $actor->addProgram($this->getReference($program));
            }
            $manager->persist($actor);
            $this->setReference('actor', $actor);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ProgramFixtures::class];
    }
}