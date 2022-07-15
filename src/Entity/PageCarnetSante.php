<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PageCarnetSanteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PageCarnetSanteRepository::class)
 */
class PageCarnetSante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"assures_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"assures_read"})
     */
    private $lienFichier;


    /**
     * @ORM\Column(type="datetime")
     * @Groups({"assures_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"assures_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"assures_read"})
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"assures_read"})
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=Assure::class, inversedBy="carnetSante")
     */
    private $assure;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLienFichier(): ?string
    {
        return $this->lienFichier;
    }

    public function setLienFichier(?string $lienFichier): self
    {
        $this->lienFichier = $lienFichier;

        return $this;
    }



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

    public function getAssure(): ?Assure
    {
        return $this->assure;
    }

    public function setAssure(?Assure $assure): self
    {
        $this->assure = $assure;

        return $this;
    }
}
