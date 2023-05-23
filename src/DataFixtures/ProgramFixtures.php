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

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {

        for ($i = 0 ; $i <= 5 ; $i ++) {
            $program = new Program();
            $program->setTitle($this->faker->words(3, true));
            $program->setSynopsis($this->faker->words(6, true));
            $program->setPoster($this->faker->imageUrl);
            $program->setCategory($this->getReference('category_Horreur'));
            $manager->persist($program);
        }

        for ($i = 0 ; $i <= 5 ; $i ++) {
            $program = new Program();
            $program->setTitle($this->faker->words(3, true));
            $program->setSynopsis($this->faker->words(6, true));
            $program->setPoster($this->faker->imageUrl);
            $program->setCategory($this->getReference('category_Action'));
            $manager->persist($program);
        }

        for ($i = 0 ; $i <= 5 ; $i ++) {
            $program = new Program();
            $program->setTitle($this->faker->words(3, true));
            $program->setSynopsis($this->faker->words(6, true));
            $program->setPoster($this->faker->imageUrl);
            $program->setCategory($this->getReference('category_Animation'));
            $manager->persist($program);
        }

        for ($i = 0 ; $i <= 5 ; $i ++) {
            $program = new Program();
            $program->setTitle($this->faker->words(3, true));
            $program->setSynopsis($this->faker->words(6, true));
            $program->setPoster($this->faker->imageUrl);
            $program->setCategory($this->getReference('category_Aventure'));
            $manager->persist($program);
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
