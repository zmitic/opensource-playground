<?php

declare(strict_types=1);

namespace App\ViewMapper;

use App\Entity\Tag;
use HTC\ViewMapper\AbstractView;
use HTC\ViewMapper\LazyCollection;

class TagView extends AbstractView
{
    public $id;

    public $value;

    /** @var PostView[]|LazyCollection  */
    public $posts;

    public function __construct(Tag $tag)
    {
        $this->id = $tag->getId();
        $this->value = $tag->getValue();

        $this->posts = PostView::lazyCollection(function () use ($tag) {
            return $tag->getPosts();
        });
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
