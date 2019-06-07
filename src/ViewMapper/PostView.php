<?php

declare(strict_types=1);

namespace App\ViewMapper;

use App\Entity\Post;
use HTC\ViewMapper\AbstractView;
use function random_int;

class PostView extends AbstractView
{
    public $body;

    public function __construct(Post $post)
    {
        $this->body = $post->getBody();
    }

    public function getRandom()
    {
        return random_int(1, 10);
    }
}
