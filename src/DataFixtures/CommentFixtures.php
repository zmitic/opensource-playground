<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use function random_int;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public const LIMIT = 10;

    public function load(ObjectManager $manager): void
    {
        $factory = Factory::create();
        for ($i = 0; $i < self::LIMIT; ++$i) {
            /** @var Post $post */
            $post = $this->getReference('post_'.random_int(0, PostFixture::LIMIT - 1));
            $post = new Comment($post, $factory->words(2, true));
            $manager->persist($post);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            PostFixture::class,
        ];
    }
}
