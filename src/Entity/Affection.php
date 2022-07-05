<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AffectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=AffectionRepository::class)
 */
class Affection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"assures_read"})
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Assure::class, inversedBy="affections")
     */
    private $antecedants;

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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getAntecedants(): ?Assure
    {
        return $this->antecedants;
    }

    public function setAntecedants(?Assure $antecedants): self
    {
        $this->antecedants = $antecedants;

        return $this;
    }
}
