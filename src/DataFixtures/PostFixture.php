<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PostFixture extends Fixture
{
    public const LIMIT = 10;

    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();
        for ($i = 0; $i < self::LIMIT; ++$i) {
            $category = new Post($factory->city);
            $manager->persist($category);
            $this->addReference('post_'.$i, $category);
        }

        $manager->flush();
    }
}
