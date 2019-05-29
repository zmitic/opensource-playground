<?php

declare(strict_types=1);

namespace App\Entity\Model;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
    /** @ORM\Column(type="datetime") */
    private $createdAt;

    /** @ORM\PrePersist() */
    public function setCreatedAt(): void
    {
        $this->createdAt = new DateTime();
    }
}
