<?php

declare(strict_types=1);

namespace App\ViewMapper;

use App\Entity\Comment;
use HTC\ViewMapper\AbstractView;

class CommentView extends AbstractView
{
    public $id;

    public $body;

    public $tags;

    public function __construct(Comment $comment)
    {
        $this->id = $comment->getId();
        $this->body = $comment->getBody();
        $this->tags = TagView::lazy(function () use ($comment) {
            return $comment->getTags();
        });
    }
}
