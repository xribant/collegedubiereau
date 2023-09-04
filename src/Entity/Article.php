<?php

namespace App\Entity;

<<<<<<<< HEAD:src/Entity/Article.php
use App\Repository\ArticleRepository;
========
use App\Repository\MenuRepository;
use DateTime;
>>>>>>>> easyadmin:src/Entity/Menu.php
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use DateTime;

<<<<<<<< HEAD:src/Entity/Article.php
#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
========
#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
>>>>>>>> easyadmin:src/Entity/Menu.php
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ["title"])]
    private ?string $slug = null;

<<<<<<<< HEAD:src/Entity/Article.php
    #[ORM\Column(length: 255)]
    private ?string $uid = null;
========
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $route = null;
>>>>>>>> easyadmin:src/Entity/Menu.php

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    public function __construct()
    {
<<<<<<<< HEAD:src/Entity/Article.php
        $this->uid = uniqid();
========
>>>>>>>> easyadmin:src/Entity/Menu.php
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

<<<<<<<< HEAD:src/Entity/Article.php
    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;
========
    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(?string $route): static
    {
        $this->route = $route;
>>>>>>>> easyadmin:src/Entity/Menu.php

        return $this;
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
}
