<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 *      normalizationContext={
 *      "groups"= {"users_read"}
  *          }
 * )
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"user" = "User", "medecin" = "Medecin","administrateur" = "Administrateur",
 *     "infirmier" = "Infirmier","pharmacien" = "Pharmacien","gerant" = "Gerant"})
 * @UniqueEntity("tel",message="Un utilisateur ayant ce numero de telephone existe déja")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=12,  unique=true)
     * @Groups({"users_read","medecins_read","assures_read"})
     * @Assert\NotBlank(message="Nous avons besoin de votre numero de telephone")
     *
     */
    private $tel;
    /**
     * @ORM\Column(type="string", length=180)
     * @Groups({"users_read","medecins_read","assures_read"})
     * @Assert\Email(message="Nous avons besoin de votre email")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $prenoms;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $genre;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $residence;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users_read","medecins_read","assures_read"})
     */
    private $numeroCni;


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
    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

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

    public function __construct()
    {
        //$this->roles [] ="ROLE_USER";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->tel;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->tel;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';

        return $roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(string $prenoms): self
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getResidence(): ?string
    {
        return $this->residence;
    }

    public function setResidence(string $residence): self
    {
        $this->residence = $residence;

        return $this;
    }

    public function getNumeroCni(): ?string
    {
        return $this->numeroCni;
    }

    public function setNumeroCni(string $numeroCni): self
    {
        $this->numeroCni = $numeroCni;

        return $this;
    }

}
