<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Conference;
use Faker\Factory;

class ConferenceFixture extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 12; $i++) {
            $manager->persist($this->getConference());
        }

        $manager->flush();
    }

    private function getConference(): Conference
    {
        return new Conference(
            $this->faker->city(),
            $this->faker->year(),
            rand(0,1) == 1
        );
    }
}
