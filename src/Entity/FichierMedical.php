<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FichierMedicalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     *  @Groups({"assures_read"})
     */
    private $typeFichier;


    /**
     * @ORM\Column(type="datetime")
     *  @Groups({"assures_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     *  @Groups({"assures_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     *  @Groups({"assures_read"})
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     *  @Groups({"assures_read"})
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=Assure::class, inversedBy="dossierMedical")
     */
    private $assure;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"assures_read"})
     */
    private $libelle;


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

    public function getAssure(): ?Assure
    {
        return $this->assure;
    }

    public function setAssure(?Assure $assure): self
    {
        $this->assure = $assure;

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

}
