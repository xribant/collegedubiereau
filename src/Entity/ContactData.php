<?php

namespace App\Entity;

use App\Repository\ContactDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactDataRepository::class)]
class ContactData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $postal_code = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $phone_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone_2 = null;

    #[ORM\Column(length: 255)]
    private ?string $email_1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email_2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postal_code;
    }

    public function setPostalCode(int $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone1(): ?string
    {
        return $this->phone_1;
    }

    public function setPhone1(string $phone_1): self
    {
        $this->phone_1 = $phone_1;

        return $this;
    }

    public function getPhone2(): ?string
    {
        return $this->phone_2;
    }

    public function setPhone2(?string $phone_2): self
    {
        $this->phone_2 = $phone_2;

        return $this;
    }

    public function getEmail1(): ?string
    {
        return $this->email_1;
    }

    public function setEmail1(string $email_1): self
    {
        $this->email_1 = $email_1;

        return $this;
    }

    public function getEmail2(): ?string
    {
        return $this->email_2;
    }

    public function setEmail2(?string $email_2): self
    {
        $this->email_2 = $email_2;

        return $this;
    }
}
