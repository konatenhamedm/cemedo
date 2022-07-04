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
