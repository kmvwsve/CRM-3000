<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAnswered;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConsumed;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateLastEmail;

	public function __toString(): string
	{
		return $this->firstname." ".$this->lastname;
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(?\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getIsAnswered(): ?bool
    {
        return $this->isAnswered;
    }

    public function setIsAnswered(bool $isAnswered): self
    {
        $this->isAnswered = $isAnswered;

        return $this;
    }

    public function getIsConsumed(): ?bool
    {
        return $this->isConsumed;
    }

    public function setIsConsumed(bool $isConsumed): self
    {
        $this->isConsumed = $isConsumed;

        return $this;
    }

    public function getDateLastEmail(): ?\DateTimeInterface
    {
        return $this->dateLastEmail;
    }

    public function setDateLastEmail(?\DateTimeInterface $dateLastEmail): self
    {
        $this->dateLastEmail = $dateLastEmail;

        return $this;
    }
}
