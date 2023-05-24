<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $categories = ['Horreur', 'Action', 'Animation', 'Aventure'];

        foreach($categories as $categoryName) {
            for ($i = 0 ; $i <= 5 ; $i ++) {
                $program = new Program();
                $program
                    ->setTitle($this->faker->words(3, true))
                    ->setSynopsis($this->faker->words(6, true))
                    ->setPoster($this->faker->imageUrl)
                    ->setCountry($this->faker->country)
                    ->setYear($this->faker->year)
                    ->setCategory($this->getReference('category_'.$categoryName));

                // Create 5 seasons for each program
                for ($j = 1; $j <= 5; $j++) {
                    $season = new Season();
                    $season
                        ->setNumber($j)
                        ->setYear($this->faker->year)
                        ->setDescription($this->faker->text)
                        ->setProgram($program); // Set the reference to the program

                    // Create 20 episodes for each season
                    for ($k = 1; $k <= 20; $k++) {
                        $episode = new Episode();
                        $episode
                            ->setTitle($this->faker->words(3, true))
                            ->setNumber($k)
                            ->setSynopsis($this->faker->text)
                            ->setSeason($season); // Set the reference to the season

                        $manager->persist($episode);
                    }

                    $manager->persist($season);
                }

                $manager->persist($program);
            }
        }

        $manager->flush();
    }

    public function getDependencies() :array
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
