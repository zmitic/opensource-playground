<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Model\UUIDTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="tbl_category")
 */
class Category
{
    use UUIDTrait;

    /** @ORM\Column(type="string", nullable=false) */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
