<?php

namespace App\Entity;

use App\Repository\BulletListRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BulletListRepository::class)]
class BulletList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $last_modified_by = null;

    #[ORM\OneToMany(mappedBy: 'parent_list', targetEntity: Bullet::class, orphanRemoval: true)]
    private Collection $bullets;

    #[ORM\ManyToOne(inversedBy: 'bulletLists')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Page $parent_page = null;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
        $this->updated_at = new DateTimeImmutable();
        $this->bullets = new ArrayCollection();
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
     * @return Collection<int, Bullet>
     */
    public function getBullets(): Collection
    {
        return $this->bullets;
    }

    public function addBullet(Bullet $bullet): static
    {
        if (!$this->bullets->contains($bullet)) {
            $this->bullets->add($bullet);
            $bullet->setParentList($this);
        }

        return $this;
    }

    public function removeBullet(Bullet $bullet): static
    {
        if ($this->bullets->removeElement($bullet)) {
            // set the owning side to null (unless already changed)
            if ($bullet->getParentList() === $this) {
                $bullet->setParentList(null);
            }
        }

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
}
