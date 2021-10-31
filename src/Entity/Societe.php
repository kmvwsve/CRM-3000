<?php

namespace App\Entity;

use App\Repository\SocieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocieteRepository::class)
 */
class Societe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Admin::class, cascade={"persist", "remove"})
     */
    private $responsable;

    /**
     * @ORM\OneToMany(targetEntity=Admin::class, mappedBy="societe")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

	public function __toString(): string
	{
		return $this->name;
	}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getResponsable(): ?Admin
    {
        return $this->responsable;
    }

    public function setResponsable(?Admin $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * @return Collection|Admin[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Admin $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setSociete($this);
        }

        return $this;
    }

    public function removeUser(Admin $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getSociete() === $this) {
                $user->setSociete(null);
            }
        }

        return $this;
    }
}
