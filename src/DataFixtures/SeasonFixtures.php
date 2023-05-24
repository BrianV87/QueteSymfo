<?php

namespace App\DataFixtures;

use App\Entity\Season;
use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $programs = $manager->getRepository(Program::class)->findAll();
        foreach ($programs as $program) {
            for ($i = 0; $i < 5; $i++) {
                $season = new Season();
                $season->setYear($this->faker->year)
                    ->setDescription($this->faker->paragraph)
                    ->setProgram($program)
                    ->setNumber($i + 1);

                $manager->persist($season);
                $this->addReference("season{$program->getId()}_{$i}", $season);
            }
        }
        $manager->flush();
    }

    public function getDependencies() :array
    {
        return [
            ProgramFixtures::class,
        ];
    }
}
