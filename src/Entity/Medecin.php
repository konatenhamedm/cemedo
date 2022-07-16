<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *    normalizationContext={
 *      "groups"= {"medecins_read"}
 *          },
 *   collectionOperations={
 *     "get",
 *     "post" = {
 *     "path"="/medecins/{id}/update",
 *       "controller" ="App\Controller\DefaultController",
 *       "deserialize" = false,
 *        "openapi_context" = {
 *         "requestBody" = {
 *           "description" = "File upload to an existing resource (superheroes)",
 *           "required" = true,
 *           "content" = {
 *             "multipart/form-data" = {
 *               "schema" = {
 *                 "type" = "object",
 *                 "properties" = {
 *                   "password" = {
 *                     "description" = "The name of the superhero",
 *                     "type" = "string",
 *                     "example" = "Clark Kent",
 *                   },
 *                   "tel" = {
 *                     "description" = "The name of the superhero",
 *                     "type" = "string",
 *                     "example" = "Clark Kent",
 *                   },
 *                   "pieceIdRecto" = {
 *                     "type" = "string",
 *                     "format" = "binary",
 *                     "description" = "Upload a cover image of the superhero",
 *                   },
 *                    "pieceIdVerso" = {
 *                     "type" = "string",
 *                     "format" = "binary",
 *                     "description" = "Upload a cover image of the superhero",
 *                   },
 *                 },
 *               },
 *             },
 *           },
 *         },
 *       },
 *     },
 *   },
 *     itemOperations={"get", "delete","put"},
 *     denormalizationContext={"disable_type_enforcement"=true}
 * )
 * @ORM\Entity(repositoryClass=MedecinRepository::class)
 */
class Medecin extends User
{
    /**
     * @ORM\Column(type="float")
     *  @Groups({"medecins_read","assures_read"})
     */
    private $salaireMedecin;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="medecin")
     * @Groups({"medecins_read"})
     */
    private $rendezVouses;

    /**
     * @ORM\ManyToOne(targetEntity=TypeMedecin::class, inversedBy="medecins")
     * @Groups({"medecins_read","assures_read"})
     */
    private $typeMedecin;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"medecins_read","assures_read"})
     */
    private $sepecialiteMedecin;

    /**
     * @ORM\Column(type="float")
     * @Groups({"medecins_read","assures_read"})
     */
    private $primeMedecin;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"medecins_read","assures_read"})
     */
    private $heureDebut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"medecins_read","assures_read"})
     */
    private $heureFin;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $photoMedecin;

    public function __construct()
    {
        $this->rendezVouses = new ArrayCollection();
    }

    public function getPhoto(): ?string
    {
        return $this->photoMedecin;
    }

    public function setPhoto(string $photo): self
    {
        $this->photoMedecin = $photo;

        return $this;
    }


    public function getSalaireMedecin(): ?float
    {
        return $this->salaireMedecin;
    }

    public function setSalaireMedecin(float $salaireMedecin): self
    {
        $this->salaireMedecin = $salaireMedecin;

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): self
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses[] = $rendezVouse;
            $rendezVouse->setMedecin($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getMedecin() === $this) {
                $rendezVouse->setMedecin(null);
            }
        }

        return $this;
    }

    public function getTypeMedecin(): ?TypeMedecin
    {
        return $this->typeMedecin;
    }

    public function setTypeMedecin(?TypeMedecin $typeMedecin): self
    {
        $this->typeMedecin = $typeMedecin;

        return $this;
    }

    public function getSepecialiteMedecin(): ?string
    {
        return $this->sepecialiteMedecin;
    }

    public function setSepecialiteMedecin(string $sepecialiteMedecin): self
    {
        $this->sepecialiteMedecin = $sepecialiteMedecin;

        return $this;
    }

    public function getPrimeMedecin(): ?float
    {
        return $this->primeMedecin;
    }

    public function setPrimeMedecin(float $primeMedecin): self
    {
        $this->primeMedecin = $primeMedecin;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeInterface $heureDebut): self
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heureFin;
    }

    public function setHeureFin(\DateTimeInterface $heureFin): self
    {
        $this->heureFin = $heureFin;

        return $this;
    }
}
