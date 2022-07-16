<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\InfirmierRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *   collectionOperations={
 *     "get",
 *     "post" = {
 *     "path"="/infirmier/{id}/update",
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
 * @ORM\Entity(repositoryClass=InfirmierRepository::class)
 */
class Infirmier extends User
{


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

    public function setPhoto(string $photo): self
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
