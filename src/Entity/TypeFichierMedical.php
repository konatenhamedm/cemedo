<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TypeFichierMedicalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TypeFichierMedicalRepository::class)
 */
class TypeFichierMedical
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"assures_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=FichierMedical::class, mappedBy="typeFichier")
     */
    private $fichierMedicals;

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
        $this->fichierMedicals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, FichierMedical>
     */
    public function getFichierMedicals(): Collection
    {
        return $this->fichierMedicals;
    }

    public function addFichierMedical(FichierMedical $fichierMedical): self
    {
        if (!$this->fichierMedicals->contains($fichierMedical)) {
            $this->fichierMedicals[] = $fichierMedical;
            $fichierMedical->setTypeFichier($this);
        }

        return $this;
    }

    public function removeFichierMedical(FichierMedical $fichierMedical): self
    {
        if ($this->fichierMedicals->removeElement($fichierMedical)) {
            // set the owning side to null (unless already changed)
            if ($fichierMedical->getTypeFichier() === $this) {
                $fichierMedical->setTypeFichier(null);
            }
        }

        return $this;
    }
}
