<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['title'])]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_name = null;

    #[Vich\UploadableField(mapping: 'article_image', fileNameProperty: 'image_name')]
    private ?File $image_file = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $last_modified_by = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Page $parent_page = null;

    #[ORM\Column(length: 255)]
    private ?string $background_color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image_position = null;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
        $this->updated_at = new DateTimeImmutable();
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

    public function getImageName(): ?string
    {
        return $this->image_name;
    }

    public function setImageName(?string $image_name): static
    {
        $this->image_name = $image_name;

        return $this;
    }

    public function setImageFile(?File $image_file): Article
    {
        $this->image_file = $image_file;

        if ($this->image_file instanceof UploadedFile) {
            $this->updated_at = new \DateTimeImmutable('now');
        }
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->image_file;
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

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getParentPage(): ?Page
    {
        return $this->parent_page;
    }

    public function setParentPage(?Page $parent_page): static
    {
        $this->parent_page = $parent_page;

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->background_color;
    }

    public function setBackgroundColor(string $background_color): static
    {
        $this->background_color = $background_color;

        return $this;
    }

    public function getImagePosition(): ?string
    {
        return $this->image_position;
    }

    public function setImagePosition(?string $image_position): static
    {
        $this->image_position = $image_position;

        return $this;
    }
}
