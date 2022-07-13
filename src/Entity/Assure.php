<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
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
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=AssureRepository::class)
 * @ApiResource(
 *      normalizationContext={
 *      "groups"= {"assures_read"}
 *          }
 * )
 * @ApiFilter(SearchFilter::class,properties={"tel": "partial"} )
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"assure" = "Assure", "patient" = "Patient","membre" = "MembreFamille"})
 * @UniqueEntity("tel",message="Un utilisateur ayant ce numéro de téléphone existe déja")
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
     * @ORM\Column(type="string", length=180)
     * @Groups({"assures_read"})
     * @Assert\Email(message="Nous avons besoin de votre email")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     *  @Groups({"assures_read"})
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read"})
     */
    private $prenoms;

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
     * @Groups({"assures_read"})
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="concerne")
     */
    private $rendezVouses;

    /**
     * @ORM\Column(type="string", length=12,  unique=true)
     * @Groups({"assures_read"})
     * @Assert\NotBlank(message="Nous avons besoin de votre email")
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     * @Groups({"assures_read"})
     */
    private $tel2;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read"})
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read"})
     */
    private $fcmtoken;

    /**
     * @ORM\Column(type="float")
     * @Groups({"assures_read"})
     */
    private $tauxCouverture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read"})
     */
    private $autreAntecedent;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read"})
     */
    private $numeroAssure;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read"})
     */
    private $lieuHabitation;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"assures_read"})
     */
    private $dateNaissance;

    /**
     * @ORM\OneToMany(targetEntity=Adresse::class, mappedBy="assure")
     * @Groups({"assures_read"})
     */
    private $adresses;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"assures_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     * @Groups({"assures_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"assures_read"})
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"assures_read"})
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="assure")
     * @Groups({"assures_read"})
     */
    private $factures;

    /**
     * @ORM\OneToMany(targetEntity=PageCarnetSante::class, mappedBy="assure")
     * @Groups({"assures_read"})
     */
    private $carnetSante;

    /**
     * @ORM\OneToMany(targetEntity=Affection::class, mappedBy="assure")
     * @Groups({"assures_read"})
     */
    private $antecedants;

    /**
     * @ORM\OneToMany(targetEntity=FichierMedical::class, mappedBy="assure")
     * @Groups({"assures_read"})
     */
    private $dossierMedical;


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

    public function __construct()
    {
        $this->ordonnances = new ArrayCollection();
        $this->dossierMedicals = new ArrayCollection();
        $this->rendezVousEmmetteur = new ArrayCollection();
        $this->rendezVouses = new ArrayCollection();
       // $this->roles [] ="ROLE_USER";
        $this->adresses = new ArrayCollection();
        $this->factures = new ArrayCollection();
        $this->carnetSante = new ArrayCollection();
        $this->antecedants = new ArrayCollection();
        $this->dossierMedical = new ArrayCollection();
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
       // $roles[] = 'ROLE_USER';

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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getTel2(): ?string
    {
        return $this->tel2;
    }

    public function setTel2(?string $tel2): self
    {
        $this->tel2 = $tel2;

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return Collection<int, Adresse>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adresse $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses[] = $adress;
            $adress->setAssure($this);
        }

        return $this;
    }

    public function removeAdress(Adresse $adress): self
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getAssure() === $this) {
                $adress->setAssure(null);
            }
        }

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
            $facture->setAssure($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getAssure() === $this) {
                $facture->setAssure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PageCarnetSante>
     */
    public function getCarnetSante(): Collection
    {
        return $this->carnetSante;
    }

    public function addCarnetSante(PageCarnetSante $carnetSante): self
    {
        if (!$this->carnetSante->contains($carnetSante)) {
            $this->carnetSante[] = $carnetSante;
            $carnetSante->setAssure($this);
        }

        return $this;
    }

    public function removeCarnetSante(PageCarnetSante $carnetSante): self
    {
        if ($this->carnetSante->removeElement($carnetSante)) {
            // set the owning side to null (unless already changed)
            if ($carnetSante->getAssure() === $this) {
                $carnetSante->setAssure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Affection>
     */
    public function getAntecedants(): Collection
    {
        return $this->antecedants;
    }

    public function addAntecedant(Affection $antecedant): self
    {
        if (!$this->antecedants->contains($antecedant)) {
            $this->antecedants[] = $antecedant;
            $antecedant->setAssure($this);
        }

        return $this;
    }

    public function removeAntecedant(Affection $antecedant): self
    {
        if ($this->antecedants->removeElement($antecedant)) {
            // set the owning side to null (unless already changed)
            if ($antecedant->getAssure() === $this) {
                $antecedant->setAssure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FichierMedical>
     */
    public function getDossierMedical(): Collection
    {
        return $this->dossierMedical;
    }

    public function addDossierMedical(FichierMedical $dossierMedical): self
    {
        if (!$this->dossierMedical->contains($dossierMedical)) {
            $this->dossierMedical[] = $dossierMedical;
            $dossierMedical->setAssure($this);
        }

        return $this;
    }

    public function removeDossierMedical(FichierMedical $dossierMedical): self
    {
        if ($this->dossierMedical->removeElement($dossierMedical)) {
            // set the owning side to null (unless already changed)
            if ($dossierMedical->getAssure() === $this) {
                $dossierMedical->setAssure(null);
            }
        }

        return $this;
    }

}
