<?php

namespace App\Entity;

use App\Repository\BlogPostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogPostRepository::class)
 */
class BlogPost
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\ManyToMany(targetEntity=CategoryPost::class, inversedBy="blogPosts")
     */
    private $categories;

    /**
     * @ORM\OneToOne(targetEntity=ImagePost::class, cascade={"persist", "remove"})
     */
    private $image;

    public $photoFilename;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="blogPost")
     */
    private $comments;

    
    

   

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return Collection|CategoryPost[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(CategoryPost $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(CategoryPost $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getImage(): ?ImagePost
    {
        return $this->image;
    }

    public function setImage(?ImagePost $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setBlogPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBlogPost() === $this) {
                $comment->setBlogPost(null);
            }
        }

        return $this;
    }

    

   

    
}
