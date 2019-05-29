<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Model\CreatedAtTrait;
use App\Entity\Model\UUIDTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @ORM\Table(name="tbl_post")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Post
{
    use UUIDTrait;
    use CreatedAtTrait;

    /** @ORM\Column(type="text", nullable=false) */
    private $body;

    /**
     * @var ArrayCollection|Tag[]
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
     * @ORM\JoinTable(name="tbl_post_tag")
     */
    private $tags;

    public function __construct(string $body)
    {
        $this->body = $body;
        $this->tags = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->body;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    /** @return Tag[] */
    public function getTags(): array
    {
        return $this->tags->toArray();
    }

    public function addTag(Tag $tag): void
    {
        $this->tags->add($tag);
    }

    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }
}
