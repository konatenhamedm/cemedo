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
     * @Groups({"assures_read"})
     * @ORM\Column(type="string", length=255)
     */
    private $numeroAssurance;

    /**
     * @ApiSubresource()
     * @ORM\OneToMany(targetEntity=MembreFamille::class, mappedBy="patient")
     */
    private $membreFamilles;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="patient")
     */
    private $notifications;

    public function __construct()
    {
        $this->membreFamilles = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }
    public function getNumeroAssurance(): ?string
    {
        return $this->numeroAssurance;
    }

    public function setNumeroAssurance(string $numeroAssurance): self
    {
        $this->numeroAssurance = $numeroAssurance;

        return $this;
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
}
