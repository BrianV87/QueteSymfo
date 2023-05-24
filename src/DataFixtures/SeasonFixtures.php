<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;
    public static int $numberOfSeason = 1;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i<ProgramFixtures::$numberOfPrograms; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $season = new Season();
                $season->setYear($this->faker->year)
                    ->setDescription($this->faker->paragraph)
                    ->setProgram($this->getReference('program_' . $i))
                    ->setNumber($j + 1);

                self::$numberOfSeason++;
                $manager->persist($season);
                $this->addReference("season_" . self::$numberOfSeason, $season);
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
