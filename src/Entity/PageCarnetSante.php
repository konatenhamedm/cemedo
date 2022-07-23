<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PageCarnetSanteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable()
 *@ApiResource(
 *     normalizationContext={"groups"= {"page_read"}},
 *      denormalizationContext={"groups"= {"write"}},
 *   collectionOperations={
 *     "get",
 *  "image_pharmacien" = {
 *       "method"="post",
 *       "path"="/page_carnet_santes/{id}/update",
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
 *     itemOperations={"GET"={"path"="/page_carnet_santes/{id}/update"},
 *     "DELETE"},
 *     denormalizationContext={"disable_type_enforcement"=true},
 * )
 * @ORM\Entity(repositoryClass=PageCarnetSanteRepository::class)
 */
class PageCarnetSante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"assures_read","page_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"assures_read","page_read"})
     */
    private $lienFichier;
    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="lienFichier")
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
     * @return PageCarnetSante
     */
    public function setFile(?File $file): PageCarnetSante
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"assures_read","page_read"})
     */
    private $createdAt;

    /**
     * @Groups({"assures_read","page_read"})
     * @Groups({"assures_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"assures_read","page_read"})
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"assures_read","page_read"})
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=Assure::class, inversedBy="carnetSante")
     */
    private $assure;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLienFichier(): ?string
    {
        return $this->lienFichier;
    }

    public function setLienFichier(?string $lienFichier): self
    {
        $this->lienFichier = $lienFichier;

        return $this;
    }



    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getAssure(): ?Assure
    {
        return $this->assure;
    }

    public function setAssure(?Assure $assure): self
    {
        $this->assure = $assure;

        return $this;
    }
}
