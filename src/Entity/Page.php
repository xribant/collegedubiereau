<?php

namespace App\Entity;

use App\Repository\PageRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[UniqueEntity('title')]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $last_modified_by = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column]
    private ?bool $published = null;

    #[ORM\ManyToOne(inversedBy: 'pages')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MainMenu $parent_menu = null;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
        $this->updated_at = new DateTimeImmutable();
        $this->published = true;
        $this->path = '/'.$this->slug;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getLastModifiedBy(): ?string
    {
        return $this->last_modified_by;
    }

    public function setLastModifiedBy(string $last_modified_by): static
    {
        $this->last_modified_by = $last_modified_by;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getParentMenu(): ?MainMenu
    {
        return $this->parent_menu;
    }

    public function setParentMenu(?MainMenu $parent_menu): static
    {
        $this->parent_menu = $parent_menu;

        return $this;
    }
}
