<?php

namespace App\Entity;


use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssuranceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *    normalizationContext={
 *      "groups"= {"assurance_read"}
 *          }
 * )
 * @ORM\Entity(repositoryClass=AssuranceRepository::class)
 */
class Assurance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"assures_read","assurance_read"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Assure::class, mappedBy="assurance")
     */
    private $assures;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read","assurance_read"})
     */
    private $emailAssurance;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"assures_read","assurance_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"assures_read","assurance_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"assures_read","assurance_read"})
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"assures_read","assurance_read"})
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read","assurance_read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read","assurance_read"})
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read","assurance_read"})
     */
    private $contact;

    /**
     * @ORM\OneToMany(targetEntity=ResponsableAssurance::class, mappedBy="assurance")
     */
    private $responsableAssurances;


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function __construct()
    {
        $this->assures = new ArrayCollection();
        $this->responsableAssurances = new ArrayCollection();
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

    public function getEmailAssurance(): ?string
    {
        return $this->emailAssurance;
    }

    public function setEmailAssurance(string $emailAssurance): self
    {
        $this->emailAssurance = $emailAssurance;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, ResponsableAssurance>
     */
    public function getResponsableAssurances(): Collection
    {
        return $this->responsableAssurances;
    }

    public function addResponsableAssurance(ResponsableAssurance $responsableAssurance): self
    {
        if (!$this->responsableAssurances->contains($responsableAssurance)) {
            $this->responsableAssurances[] = $responsableAssurance;
            $responsableAssurance->setAssurance($this);
        }

        return $this;
    }

    public function removeResponsableAssurance(ResponsableAssurance $responsableAssurance): self
    {
        if ($this->responsableAssurances->removeElement($responsableAssurance)) {
            // set the owning side to null (unless already changed)
            if ($responsableAssurance->getAssurance() === $this) {
                $responsableAssurance->setAssurance(null);
            }
        }

        return $this;
    }
}
