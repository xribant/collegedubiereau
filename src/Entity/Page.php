<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Vich\UploaderBundle\Entity\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[Vich\Uploadable]
class Page
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
    private ?string $banner_image = null;

    #[Vich\UploadableField(mapping: 'page_banner_image', fileNameProperty: 'banner_image')]
    private $bannerImageFile;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: Article::class)]
    private Collection $articles;

    #[ORM\OneToOne(inversedBy: 'page', cascade: ['persist', 'remove'])]
    private ?Menu $parent_menu = null;

    #[ORM\OneToOne(inversedBy: 'page', cascade: ['persist', 'remove'])]
    private ?SubMenu $parent_sub_menu = null;

    public function __toString()
    {
        return $this->title;
    }

    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
        $this->articles = new ArrayCollection();
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

    public function getBannerImage(): ?string
    {
        return $this->banner_image;
    }

    public function setBannerImage(?string $banner_image): static
    {
        $this->banner_image = $banner_image;

        return $this;
    }

    public function setBannerImafeFile(?File $bannerImageFile): Page
    {
        $this->bannerImageFile = $bannerImageFile;

        if ($this->bannerImageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function getBannerImageFile(): ?File
    {
        return $this->bannerImageFile;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setPage($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getPage() === $this) {
                $article->setPage(null);
            }
        }

        return $this;
    }

    public function getParentMenu(): ?Menu
    {
        return $this->parent_menu;
    }

    public function setParentMenu(?Menu $parent_menu): static
    {
        $this->parent_menu = $parent_menu;

        return $this;
    }

    public function getParentSubMenu(): ?SubMenu
    {
        return $this->parent_sub_menu;
    }

    public function setParentSubMenu(?SubMenu $parent_sub_menu): static
    {
        $this->parent_sub_menu = $parent_sub_menu;

        return $this;
    }
}
