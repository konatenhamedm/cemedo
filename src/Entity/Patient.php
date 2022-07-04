<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PatientRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *
 *      * itemOperations={"GET","PUT","DELETE","increment"={
 *     "method"="get",
 *     "path"="/invoices/{id}/increment"
 *      ,"controller"="App\Controller\DefaultController",
 *      "swagger_context"={
 *         "summary"="Incremente une facture",
 *        "description"="Permet de creer une facture"
 *     }
 *     }}
 * )
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient extends Assure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ApiSubresource()
     * @ORM\OneToMany(targetEntity=MembreFamille::class, mappedBy="patient")
     */
    private $membreFamilles;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="patient")
     */
    private $notifications;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pieceIdRecto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pieceIdVerso;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $assuranceRecto;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $assuranceVerso;

    public function __construct()
    {
        $this->membreFamilles = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    /**
     * @return Collection<int, MembreFamille>
     */
    public function getMembreFamilles(): Collection
    {
        return $this->membreFamilles;
    }

    public function addMembreFamille(MembreFamille $membreFamille): self
    {
        if (!$this->membreFamilles->contains($membreFamille)) {
            $this->membreFamilles[] = $membreFamille;
            $membreFamille->setPatient($this);
        }

        return $this;
    }

    public function removeMembreFamille(MembreFamille $membreFamille): self
    {
        if ($this->membreFamilles->removeElement($membreFamille)) {
            // set the owning side to null (unless already changed)
            if ($membreFamille->getPatient() === $this) {
                $membreFamille->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setPatient($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getPatient() === $this) {
                $notification->setPatient(null);
            }
        }

        return $this;
    }

    public function getPieceIdRecto(): ?string
    {
        return $this->pieceIdRecto;
    }

    public function setPieceIdRecto(?string $pieceIdRecto): self
    {
        $this->pieceIdRecto = $pieceIdRecto;

        return $this;
    }

    public function getPieceIdVerso(): ?string
    {
        return $this->pieceIdVerso;
    }

    public function setPieceIdVerso(?string $pieceIdVerso): self
    {
        $this->pieceIdVerso = $pieceIdVerso;

        return $this;
    }

    public function getAssuranceRecto(): ?string
    {
        return $this->assuranceRecto;
    }

    public function setAssuranceRecto(string $assuranceRecto): self
    {
        $this->assuranceRecto = $assuranceRecto;

        return $this;
    }

    public function getAssuranceVerso(): ?string
    {
        return $this->assuranceVerso;
    }

    public function setAssuranceVerso(string $assuranceVerso): self
    {
        $this->assuranceVerso = $assuranceVerso;

        return $this;
    }
}
