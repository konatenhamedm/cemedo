<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AssureRepository::class)
 * @ApiResource(
 *      normalizationContext={
 *      "groups"= {"assures_read"}
 *          }
 * )
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"assure" = "Assure", "patient" = "Patient","membre" = "MembreFamille"})
 * @UniqueEntity("email",message="Un utilisateur ayant cette adresse email existe déja")
 */
class Assure implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"assures_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"assures_read"})
     * @Assert\Email(message="Nous avons besoin de votre email")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"users_read","customers_read","invoices_read"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read"})
     */
    private $lastName;

    /**
     * @Groups({"assures_read"})
     * @ORM\ManyToOne(targetEntity=Assurance::class, inversedBy="assures")
     */
    private $assurance;

    /**
     * @Groups({"assures_read"})
     * @ORM\OneToMany(targetEntity=Ordonnance::class, mappedBy="assure")
     */
    private $ordonnances;

    /**
     * @ORM\OneToMany(targetEntity=DossierMedical::class, mappedBy="assure")
     */
    private $dossierMedicals;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="emetteur")
     */
    private $rendezVousEmmetteur;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="concerne")
     */
    private $rendezVouses;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $telephone1;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $telephone2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fcmtoken;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="float")
     */
    private $tauxCouverture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $autreAntecedent;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroAssure;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieuHabitation;



    public function __construct()
    {
        $this->ordonnances = new ArrayCollection();
        $this->dossierMedicals = new ArrayCollection();
        $this->rendezVousEmmetteur = new ArrayCollection();
        $this->rendezVouses = new ArrayCollection();
        $this->roles [] ="ROLE_USER";
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
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAssurance(): ?Assurance
    {
        return $this->assurance;
    }

    public function setAssurance(?Assurance $assurance): self
    {
        $this->assurance = $assurance;

        return $this;
    }

    /**
     * @return Collection<int, Ordonnance>
     */
    public function getOrdonnances(): Collection
    {
        return $this->ordonnances;
    }

    public function addOrdonnance(Ordonnance $ordonnance): self
    {
        if (!$this->ordonnances->contains($ordonnance)) {
            $this->ordonnances[] = $ordonnance;
            $ordonnance->setAssure($this);
        }

        return $this;
    }

    public function removeOrdonnance(Ordonnance $ordonnance): self
    {
        if ($this->ordonnances->removeElement($ordonnance)) {
            // set the owning side to null (unless already changed)
            if ($ordonnance->getAssure() === $this) {
                $ordonnance->setAssure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DossierMedical>
     */
    public function getDossierMedicals(): Collection
    {
        return $this->dossierMedicals;
    }

    public function addDossierMedical(DossierMedical $dossierMedical): self
    {
        if (!$this->dossierMedicals->contains($dossierMedical)) {
            $this->dossierMedicals[] = $dossierMedical;
            $dossierMedical->setAssure($this);
        }

        return $this;
    }

    public function removeDossierMedical(DossierMedical $dossierMedical): self
    {
        if ($this->dossierMedicals->removeElement($dossierMedical)) {
            // set the owning side to null (unless already changed)
            if ($dossierMedical->getAssure() === $this) {
                $dossierMedical->setAssure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RendezVous>
     */
    public function getRendezVousEmmetteur(): Collection
    {
        return $this->rendezVousEmmetteur;
    }

    public function addRendezVousEmmetteur(RendezVous $rendezVousEmmetteur): self
    {
        if (!$this->rendezVousEmmetteur->contains($rendezVousEmmetteur)) {
            $this->rendezVousEmmetteur[] = $rendezVousEmmetteur;
            $rendezVousEmmetteur->setEmetteur($this);
        }

        return $this;
    }

    public function removeRendezVousEmmetteur(RendezVous $rendezVousEmmetteur): self
    {
        if ($this->rendezVousEmmetteur->removeElement($rendezVousEmmetteur)) {
            // set the owning side to null (unless already changed)
            if ($rendezVousEmmetteur->getEmetteur() === $this) {
                $rendezVousEmmetteur->setEmetteur(null);
            }
        }

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
            $rendezVouse->setConcerne($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->removeElement($rendezVouse)) {
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getConcerne() === $this) {
                $rendezVouse->setConcerne(null);
            }
        }

        return $this;
    }

    public function getTelephone1(): ?string
    {
        return $this->telephone1;
    }

    public function setTelephone1(?string $telephone1): self
    {
        $this->telephone1 = $telephone1;

        return $this;
    }

    public function getTelephone2(): ?string
    {
        return $this->telephone2;
    }

    public function setTelephone2(?string $telephone2): self
    {
        $this->telephone2 = $telephone2;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getFcmtoken(): ?string
    {
        return $this->fcmtoken;
    }

    public function setFcmtoken(string $fcmtoken): self
    {
        $this->fcmtoken = $fcmtoken;

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

    public function getTauxCouverture(): ?float
    {
        return $this->tauxCouverture;
    }

    public function setTauxCouverture(float $tauxCouverture): self
    {
        $this->tauxCouverture = $tauxCouverture;

        return $this;
    }

    public function getAutreAntecedent(): ?string
    {
        return $this->autreAntecedent;
    }

    public function setAutreAntecedent(string $autreAntecedent): self
    {
        $this->autreAntecedent = $autreAntecedent;

        return $this;
    }

    public function getNumeroAssure(): ?string
    {
        return $this->numeroAssure;
    }

    public function setNumeroAssure(string $numeroAssure): self
    {
        $this->numeroAssure = $numeroAssure;

        return $this;
    }

    public function getLieuHabitation(): ?string
    {
        return $this->lieuHabitation;
    }

    public function setLieuHabitation(string $lieuHabitation): self
    {
        $this->lieuHabitation = $lieuHabitation;

        return $this;
    }

}
