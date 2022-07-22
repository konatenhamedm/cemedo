<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComptableRepository;
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
 *       "path"="/comptables/{id}/update",
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
 *     itemOperations={"GET"={"path"="/comptables/{id}/update"},
 *     "DELETE"},
 *     denormalizationContext={"disable_type_enforcement"=true},
 * )
 * @ORM\Entity(repositoryClass=ComptableRepository::class)
 */
class Comptable extends User
{

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="photoComptable")
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
     * @return Comptable
     */
    public function setFile(?File $file): Comptable
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $photoComptable;

    public function getPhoto(): ?string
    {
        return $this->photoComptable;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photoComptable = $photo;

        return $this;
    }
}
