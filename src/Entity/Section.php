<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: SectionRepository::class)]
class Section
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $short_name = null;

    #[ORM\Column(length: 255)]
    #[Gedmo\Slug(fields: ['short_name'])]
    private ?string $slug = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToMany(targetEntity: Member::class, mappedBy: 'section')]
    private Collection $members;

    #[ORM\Column(length: 255)]
    private ?string $last_modified_by = null;

    #[ORM\Column(length: 255)]
    private ?string $full_name = null;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
        $this->updated_at = new DateTimeImmutable();
        $this->members = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getShortName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShortName(): ?string
    {
        return $this->short_name;
    }

    public function setShortName(string $short_name): static
    {
        $this->short_name = $short_name;

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

    /**
     * @return Collection<int, Member>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->addSection($this);
        }

        return $this;
    }

    public function removeMember(Member $member): static
    {
        if ($this->members->removeElement($member)) {
            $member->removeSection($this);
        }

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

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): static
    {
        $this->full_name = $full_name;

        return $this;
    }
}
