<?php

namespace App\Entity;

use App\Repository\AffectionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
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
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Assure::class, inversedBy="affections")
     */
    private $antecedants;

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
