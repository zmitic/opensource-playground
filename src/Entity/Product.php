<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Model\UUIDTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="tbl_product")
 */
class Product
{
    use UUIDTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(onDelete="CASCADE")
     *
     * @Assert\NotNull(message="You must select categoryf")
     */
    private $category;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\NotNull()
     * @Assert\Length(min="3")
     */
    private $name;

    public function __construct(Category $category, string $name)
    {
        $this->category = $category;
        $this->name = $name;
    }

    public function __toString()
    {
        return (string)'---'.$this->name;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
