<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FichierMedicalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=FichierMedicalRepository::class)
 */
class FichierMedical
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=TypeFichierMedical::class, inversedBy="fichierMedicals")
     */
    private $typeFichier;

    /**
     * @ORM\ManyToOne(targetEntity=Assure::class, inversedBy="fichierMedicals")
     */
    private $dossierMedical;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;


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
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeFichier(): ?TypeFichierMedical
    {
        return $this->typeFichier;
    }

    public function setTypeFichier(?TypeFichierMedical $typeFichier): self
    {
        $this->typeFichier = $typeFichier;

        return $this;
    }

    public function getDossierMedical(): ?Assure
    {
        return $this->dossierMedical;
    }

    public function setDossierMedical(?Assure $dossierMedical): self
    {
        $this->dossierMedical = $dossierMedical;

        return $this;
    }
}
