<?php

declare(strict_types=1);

namespace App\ViewMapper;

use App\Entity\Tag;

class TagViewMapper extends AbstractViewMapper
{
    /** @param Tag $tag */
    public static function single($tag): array
    {
        return [
            'id' => $tag->getId(),
            'value' => $tag->getValue(),
        ];
    }
}
