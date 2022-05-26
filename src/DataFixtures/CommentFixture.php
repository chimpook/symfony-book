<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Conference;
use App\Entity\Comment;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\ConferenceFixture;

class CommentFixture extends Fixture implements DependentFixtureInterface
{
    private $faker;
    private $conferences;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        $conferences = $manager->getRepository(Conference::class)->findAll();
        foreach ($conferences as $conference) {
            $num_comments = rand(1,12);
            for ($i = 0; $i < $num_comments; $i++) {
                $manager->persist($this->getComment($conference));
            }
        }
        $manager->flush();
    }

    private function getComment($conference)
    {
        $comment = new Comment();
        $comment->setAuthor($this->faker->name());
        $comment->setText($this->faker->realtext());
        $comment->setState('published');
        $comment->setEmail($this->faker->email());
        $comment->setCreatedAt(\DateTimeImmutable::createFromMutable($this->faker->dateTimeThisDecade()));
        $comment->setConference($conference);
        $comment->setPhotoFilename('https://picsum.photos/seed/' . rand() . '/320/240');

        return $comment;
    }

    public function getDependencies()
    {
        return [ConferenceFixture::class];
    }
}
