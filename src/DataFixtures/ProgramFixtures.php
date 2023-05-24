<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private Generator $faker;
    public static int $numberOfPrograms = 1;

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

                $this->addReference('program_' . self::$numberOfPrograms, $program);
                self::$numberOfPrograms++;
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
