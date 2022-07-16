<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdministrateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *   collectionOperations={
 *     "get",
 *     "post" = {
 *     "path"="/administrateurs/{id}/update",
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
 * @ORM\Entity(repositoryClass=AdministrateurRepository::class)
 */
class Administrateur extends User
{
    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="administrateur")
     */
    private $factures;
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $photoAdmininstareur;

    public function __construct()
    {
        parent::__construct();
        $this->factures = new ArrayCollection();
    }


    public function getPhoto(): ?string
    {
        return $this->photoAdmininstareur;
    }

    public function setPhoto(string $photo): self
    {
        $this->photoAdmininstareur = $photo;

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setAdministrateur($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getAdministrateur() === $this) {
                $facture->setAdministrateur(null);
            }
        }

        return $this;
    }
}
