<?php

namespace App\Entity;

use App\Repository\InfoSessionDayRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InfoSessionDayRepository::class)]
class InfoSessionDay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $session_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $last_modified_by = null;

    #[ORM\Column]
    private ?bool $enabled = null;

    #[ORM\OneToMany(mappedBy: 'info_session_day', targetEntity: InfoRegistration::class, orphanRemoval: true)]
    private Collection $infoRegistrations;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
        $this->updated_at = new DateTimeImmutable();
        $this->enabled = false;
        $this->infoRegistrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionDate(): ?\DateTimeImmutable
    {
        return $this->session_date;
    }

    public function setSessionDate(\DateTimeImmutable $session_date): static
    {
        $this->session_date = $session_date;

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

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection<int, InfoRegistration>
     */
    public function getInfoRegistrations(): Collection
    {
        return $this->infoRegistrations;
    }

    public function addInfoRegistration(InfoRegistration $infoRegistration): static
    {
        if (!$this->infoRegistrations->contains($infoRegistration)) {
            $this->infoRegistrations->add($infoRegistration);
            $infoRegistration->setInfoSessionDay($this);
        }

        return $this;
    }

    public function removeInfoRegistration(InfoRegistration $infoRegistration): static
    {
        if ($this->infoRegistrations->removeElement($infoRegistration)) {
            // set the owning side to null (unless already changed)
            if ($infoRegistration->getInfoSessionDay() === $this) {
                $infoRegistration->setInfoSessionDay(null);
            }
        }

        return $this;
    }
}
