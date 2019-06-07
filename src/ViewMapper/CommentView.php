<?php

declare(strict_types=1);

namespace App\ViewMapper;

use App\Entity\Comment;
use HTC\ViewMapper\AbstractView;
use HTC\ViewMapper\LazyProperty;

class CommentView extends AbstractView
{
    public $id;

    public $body;

    public $tags;

    /** @var PostView|LazyProperty */
    public $post;

    public function __construct(Comment $comment)
    {
        $this->id = $comment->getId();
        $this->body = $comment->getBody();

        $this->post = PostView::lazyProperty(function () use ($comment) {
            return $comment->getPost();
        });

        $this->tags = TagView::lazyCollection(function () use ($comment) {
            return $comment->getTags();
        });
    }
}
