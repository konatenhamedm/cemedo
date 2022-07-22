<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InfirmierRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable()
 *@ApiResource(
 *      denormalizationContext={"groups"= {"write"}},
 *   collectionOperations={
 *     "get",
 *  "image_infirmier" = {
 *       "method"="post",
 *       "path"="/infirmiers/{id}/update",
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
 *     itemOperations={"GET"={"path"="/infirmiers/{id}/update"},
 *     "DELETE"},
 * )
 * @ORM\Entity(repositoryClass=InfirmierRepository::class)
 */
class Infirmier extends User
{
    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="photoInfirmier")
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
     * @ORM\Column(type="float")
     */
    private $salaireInfirmier;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $photoInfirmier;

    public function getPhoto(): ?string
    {
        return $this->photoInfirmier;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photoInfirmier = $photo;

        return $this;
    }

    public function getSalaireInfirmier(): ?float
    {
        return $this->salaireInfirmier;
    }

    public function setSalaireInfirmier(float $salaireInfirmier): self
    {
        $this->salaireInfirmier = $salaireInfirmier;

        return $this;
    }
}
