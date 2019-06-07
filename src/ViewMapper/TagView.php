<?php

declare(strict_types=1);

namespace App\ViewMapper;

use App\Entity\Tag;
use HTC\ViewMapper\AbstractView;

class TagView extends AbstractView
{
    public $id;

    public $value;

    public $posts;

    public function __construct(Tag $tag)
    {
        $this->id = $tag->getId();
        $this->value = $tag->getValue();
        $this->posts = PostView::lazy(function () {
            return [
                'a', 'b', 'c',
            ];
        });
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
