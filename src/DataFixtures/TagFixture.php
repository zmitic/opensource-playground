<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class TagFixture extends Fixture
{
    public const LIMIT = 10;

    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();
        for ($i = 0; $i < self::LIMIT; ++$i) {
            $category = new Tag($factory->word);
            $manager->persist($category);
            $this->addReference('tag_'.$i, $category);
        }

        $manager->flush();
    }
}
