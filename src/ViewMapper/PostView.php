<?php

declare(strict_types=1);

namespace App\ViewMapper;

use App\ViewMapper\Model\AbstractView;

class PostView extends AbstractView
{
    public $dummy;

    public function __construct(string $dummy)
    {
        $this->dummy = $dummy;
    }
}
