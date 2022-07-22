<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GerantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable()
 *@ApiResource(
 *     denormalizationContext={"groups"= {"write"}},
 *   collectionOperations={
 *     "get",
 *  "image_gerant" = {
 *       "method"="post",
 *       "path"="/gerants/{id}/update",
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
 *     itemOperations={"GET"={"path"="/gerants/{id}/update"},
 *     "DELETE"},
 * )
 * @ORM\Entity(repositoryClass=GerantRepository::class)
 */
class Gerant extends User
{
    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="photoGerant")
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
     * @return Gerant
     */
    public function setFile(?File $file): Gerant
    {
        $this->file = $file;
        return $this;
    }


    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="gerant")
     */
    private $rendezVouses;
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $photoGerant;

    public function __construct()
    {
        $this->rendezVouses = new ArrayCollection();
    }


    public function getPhoto(): ?string
    {
        return $this->photoGerant;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photoGerant = $photo;

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
            $rendezVouse->setGerant($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getGerant() === $this) {
                $rendezVouse->setGerant(null);
            }
        }

        return $this;
    }
}
