<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AdministrateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable()
 *@ApiResource(
 *   normalizationContext={"groups"= {"admin_read"}},
 *     denormalizationContext={"groups"= {"write"}},
 *   collectionOperations={
 *     "get",
 *  "image_admin" = {
 *       "method"="post",
 *       "path"="/administrateurs/{id}/update",
 *       "controller" ="App\Controller\DefaultController",
 *       "openapi_context" = {
 *         "requestBody" = {
 *           "description" = "File Upload",
 *           "required" = true,
 *           "content" = {
 *             "multipart/form-data" = {
 *               "schema" = {
 *                 "type" = "object",
 *                 "properties" = {
 *                   "file" = {
 *                     "type" = "string",
 *                     "format" = "binary",
 *                     "description" = "File to be uploaded",
 *                   },
 *                 },
 *               },
 *             },
 *           },
 *         },
 *       },
 *     },
 *   },
 *     itemOperations={"GET"={"path"="/administrateurs/{id}/update"},
 *     "DELETE"},
 * )
 * @ORM\Entity(repositoryClass=AdministrateurRepository::class)
 */
class Administrateur extends User
{
    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="administrateur")
     * @Groups({"admin_read"})
     */
    private $factures;
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"users_read","medecins_read","assures_read","admin_read"})
     */
    private $photoAdmininstareur;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="photoAdmininstareur")
     * @Groups({"write"})
     */
    private $file ;


    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     *
     * @param File|null $file
     * @return Administrateur
     */
    public function setFile(?File $file): Administrateur
    {
        $this->file = $file;
        return $this;
    }

    public function __construct()
    {
        parent::__construct();
        $this->factures = new ArrayCollection();
    }


    public function getPhoto(): ?string
    {
        return $this->photoAdmininstareur;
    }

    public function setPhoto(?string $photo): self
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
