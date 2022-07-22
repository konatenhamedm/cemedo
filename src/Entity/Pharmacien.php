<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PharmacienRepository;
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
 *  "image_pharmacien" = {
 *       "method"="post",
 *       "path"="/pharmaciens/{id}/update",
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
 *     itemOperations={"GET"={"path"="/pharmaciens/{id}/update"},
 *     "DELETE"},
 *     denormalizationContext={"disable_type_enforcement"=true},
 * )
 * @ORM\Entity(repositoryClass=PharmacienRepository::class)
 */
class Pharmacien extends User
{

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="photoPharmacien")
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
     * @return Pharmacien
     */
    public function setFile(?File $file): Pharmacien
    {
        $this->file = $file;
        return $this;
    }
    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $photoPharmacien;

    public function getPhoto(): ?string
    {
        return $this->photoPharmacien;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photoPharmacien = $photo;

        return $this;
    }

}
