<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RendezVousRepository::class)
 */
class RendezVous
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Gerant::class, inversedBy="rendezVouses")
     */
    private $gerant;

    /**
     * @ORM\ManyToOne(targetEntity=Assure::class, inversedBy="rendezVousEmmetteur")
     */
    private $emetteur;

    /**
     * @ORM\ManyToOne(targetEntity=Assure::class, inversedBy="rendezVouses")
     */
    private $concerne;

    /**
     * @ORM\ManyToOne(targetEntity=Medecin::class, inversedBy="rendezVouses")
     */
    private $medecin;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="rendezVouses")
     */
    private $service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGerant(): ?Gerant
    {
        return $this->gerant;
    }

    public function setGerant(?Gerant $gerant): self
    {
        $this->gerant = $gerant;

        return $this;
    }

    public function getEmetteur(): ?Assure
    {
        return $this->emetteur;
    }

    public function setEmetteur(?Assure $emetteur): self
    {
        $this->emetteur = $emetteur;

        return $this;
    }

    public function getConcerne(): ?Assure
    {
        return $this->concerne;
    }

    public function setConcerne(?Assure $concerne): self
    {
        $this->concerne = $concerne;

        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }
}
