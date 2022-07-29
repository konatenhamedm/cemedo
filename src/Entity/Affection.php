<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AffectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *     "get",
 *    "increment"={
 *     "method"="post",
 *     "path"="/affecions/update"
 *      ,"controller"="App\Controller\DefaultController",
 *      "swagger_context"={
 *         "summary"="Incremente une facture",
 *        "description"="Permet de creer une facture"
 *     }
 *     }
 *     }
 * )
 * @ORM\Entity(repositoryClass=AffectionRepository::class)
 */
class Affection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"assures_read","patient_read"})
     */
    private $id;


    /**
     * @ORM\Column(type="datetime")
     *  @Groups({"assures_read","patient_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     *  @Groups({"assures_read","patient_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     *  @Groups({"assures_read","patient_read"})
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     *  @Groups({"assures_read","patient_read"})
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"assures_read","patient_read"})
     */
    private $cle;

    /**
     * @ORM\ManyToOne(targetEntity=Assure::class, inversedBy="antecedants")
     */
    private $assure;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"assures_read","patient_read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;



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

    public function getCle(): ?string
    {
        return $this->cle;
    }

    public function setCle(string $cle): self
    {
        $this->cle = $cle;

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

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

}
