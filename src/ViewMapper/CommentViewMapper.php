<?php

declare(strict_types=1);

namespace App\ViewMapper;

use App\Entity\Comment;

class CommentViewMapper extends AbstractViewMapper
{
    /** @param Comment $comment */
    public static function single($comment): array
    {
        return [
            'id' => $comment->getId(),
            'body' => $comment->getBody(),
        ];
    }
}
