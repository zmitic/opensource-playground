<?php

declare(strict_types=1);

namespace App\ViewMapper;


use HTC\ViewMapper\AbstractView;

class PostView extends AbstractView
{
    public $dummy;

    public function __construct(string $dummy)
    {
        $this->dummy = $dummy;
    }
}
