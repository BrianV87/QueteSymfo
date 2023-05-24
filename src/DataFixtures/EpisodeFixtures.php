<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $seasons = $manager->getRepository(Season::class)->findAll();
        foreach ($seasons as $season) {
            for ($i = 0; $i < 20; $i++) {
                $episode = new Episode();
                $episode->setTitle($this->faker->sentence)
                    ->setSynopsis($this->faker->paragraph)
                    ->setNumber($i + 1)
                    ->setSeason($season);
                $manager->persist($episode);
            }
        }
        $manager->flush();
    }

    public function getDependencies() :array
    {
        return [
            SeasonFixtures::class,
        ];
    }
}
