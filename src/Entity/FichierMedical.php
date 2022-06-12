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
     * @ORM\ManyToOne(targetEntity=DossierMedical::class, inversedBy="fichierMedicals")
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity=TypeFichierMedical::class, inversedBy="fichierMedicals")
     */
    private $typeFichier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDossier(): ?DossierMedical
    {
        return $this->dossier;
    }

    public function setDossier(?DossierMedical $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
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
}
