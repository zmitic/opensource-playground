<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();
        for ($i = 0; $i < 100; ++$i) {
            $category = new Category($factory->company);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
