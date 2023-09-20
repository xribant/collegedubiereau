<?php

namespace App\Entity;

use App\Repository\MainMenuRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: MainMenuRepository::class)]
class MainMenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $last_modified_by = null;

    #[ORM\OneToMany(mappedBy: 'parent_menu', targetEntity: SubMenu::class, cascade:['persist'])]
    private Collection $subMenus;

    #[ORM\Column]
    #[Gedmo\SortablePosition]
    private int $position = 0;

    #[ORM\OneToMany(mappedBy: 'parent_menu', targetEntity: Page::class)]
    private Collection $pages;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
        $this->updated_at = new DateTimeImmutable();
        $this->subMenus = new ArrayCollection();
        $this->pages = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    /**
     * @return Collection<int, SubMenu>
     */
    public function getSubMenus(): Collection
    {
        return $this->subMenus;
    }

    public function addSubMenu(SubMenu $subMenu): static
    {
        if (!$this->subMenus->contains($subMenu)) {
            $this->subMenus->add($subMenu);
            $subMenu->setParentMenu($this);
        }

        return $this;
    }

    public function removeSubMenu(SubMenu $subMenu): static
    {
        if ($this->subMenus->removeElement($subMenu)) {
            // set the owning side to null (unless already changed)
            if ($subMenu->getParentMenu() === $this) {
                $subMenu->setParentMenu(null);
            }
        }

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection<int, Page>
     */
    public function getPages(): Collection
    {
        return $this->pages;
    }

    public function addPage(Page $page): static
    {
        if (!$this->pages->contains($page)) {
            $this->pages->add($page);
            $page->setParentMenu($this);
        }

        return $this;
    }

    public function removePage(Page $page): static
    {
        if ($this->pages->removeElement($page)) {
            // set the owning side to null (unless already changed)
            if ($page->getParentMenu() === $this) {
                $page->setParentMenu(null);
            }
        }

        return $this;
    }
}
