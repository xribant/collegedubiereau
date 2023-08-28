<?php

namespace App\Entity;

use App\Repository\MenuEntryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity(repositoryClass: MenuEntryRepository::class)]
class MenuEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'menuEntries')]
    private ?self $parent_menu = null;

    #[ORM\OneToMany(mappedBy: 'parent_menu', targetEntity: self::class)]
    private Collection $menuEntries;

    #[ORM\Column(length: 255)]
    private ?string $uid = null;

    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
        $this->uid = uniqid();
        $this->menuEntries = new ArrayCollection();
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

    public function getParentMenu(): ?self
    {
        return $this->parent_menu;
    }

    public function setParentMenu(?self $parent_menu): static
    {
        $this->parent_menu = $parent_menu;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getMenuEntries(): Collection
    {
        return $this->menuEntries;
    }

    public function addMenuEntry(self $menuEntry): static
    {
        if (!$this->menuEntries->contains($menuEntry)) {
            $this->menuEntries->add($menuEntry);
            $menuEntry->setParentMenu($this);
        }

        return $this;
    }

    public function removeMenuEntry(self $menuEntry): static
    {
        if ($this->menuEntries->removeElement($menuEntry)) {
            // set the owning side to null (unless already changed)
            if ($menuEntry->getParentMenu() === $this) {
                $menuEntry->setParentMenu(null);
            }
        }

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }
}
