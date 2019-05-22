<?php

declare(strict_types=1);

namespace App\Entity\Model;

use Ramsey\Uuid\UuidInterface;

trait UUIDTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }
}
