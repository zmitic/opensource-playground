<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Model\CreatedAtTrait;
use App\Entity\Model\UUIDTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 * @ORM\Table(name="tbl_tag")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Tag
{
    use UUIDTrait;
    use CreatedAtTrait;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @Assert\Length(min=5, minMessage="Put at least {{ limit }} characters.")
     */
    private $value;

    /**
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="tags")
     */
    private $posts;

    public function __construct(string $value)
    {
        $this->value = $value;
        $this->posts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /** @return Post[] */
    public function getPosts(): array
    {
        return $this->posts->toArray();
    }
}
