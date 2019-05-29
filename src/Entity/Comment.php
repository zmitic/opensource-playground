<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Model\CreatedAtTrait;
use App\Entity\Model\UUIDTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\Table(name="tbl_comment")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Comment
{
    use UUIDTrait;
    use CreatedAtTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $post;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Assert\NotNull()
     * @Assert\Length(min="3")
     */
    private $body;

    /**
     * @var ArrayCollection|Tag[]
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
     * @ORM\JoinTable(name="tbl_comment_tag")
     *
     * @Assert\Valid()
     */
    private $tags;

    public function __construct(Post $post, string $body)
    {
        $this->post = $post;
        $this->body = $body;
        $this->tags = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->body;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
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
