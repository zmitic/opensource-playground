<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixture extends Fixture
{
    public const LIMIT = 30;

    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();
        for ($i = 0; $i < self::LIMIT; ++$i) {
            $category = new Category($factory->company);
            $manager->persist($category);
            $this->addReference('category_'.$i, $category);
        }

        $manager->flush();
    }
}
