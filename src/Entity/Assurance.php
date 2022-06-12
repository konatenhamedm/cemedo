<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssuranceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AssuranceRepository::class)
 */
class Assurance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Assure::class, mappedBy="assurance")
     */
    private $assures;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomAssurance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailAssurance;

    public function __construct()
    {
        $this->assures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Assure>
     */
    public function getAssures(): Collection
    {
        return $this->assures;
    }

    public function addAssure(Assure $assure): self
    {
        if (!$this->assures->contains($assure)) {
            $this->assures[] = $assure;
            $assure->setAssurance($this);
        }

        return $this;
    }

    public function removeAssure(Assure $assure): self
    {
        if ($this->assures->removeElement($assure)) {
            // set the owning side to null (unless already changed)
            if ($assure->getAssurance() === $this) {
                $assure->setAssurance(null);
            }
        }

        return $this;
    }

    public function getNomAssurance(): ?string
    {
        return $this->nomAssurance;
    }

    public function setNomAssurance(string $nomAssurance): self
    {
        $this->nomAssurance = $nomAssurance;

        return $this;
    }

    public function getEmailAssurance(): ?string
    {
        return $this->emailAssurance;
    }

    public function setEmailAssurance(string $emailAssurance): self
    {
        $this->emailAssurance = $emailAssurance;

        return $this;
    }
}
