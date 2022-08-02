<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AssureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable()
 * @ORM\Entity(repositoryClass=AssureRepository::class)
 * @ApiResource(
 *      normalizationContext={
 *      "groups"= {"assures_read"}
 *          },
 *     denormalizationContext={"disable_type_enforcement"=true}
 * )
 * @ApiFilter(SearchFilter::class,properties={"tel": "exact"} )
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
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="pieceIdRecto")
     * @Groups({"write"})
     */
    private $file ;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="pieceIdVerso")
     * @Groups({"write"})
     */
    private $filePieceVerso ;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="assuranceRecto")
     * @Groups({"write"})
     */
    private $fileAssuranceRecto ;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="fichiers",fileNameProperty="assuranceVerso")
     * @Groups({"write"})
     */
    private $fileAssuranceVerso ;


    /**
     * @return File|null
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * @return File|null
     */
    public function getFilePieceVerso(): ?File
    {
        return $this->filePieceVerso;
    }
    /**
     * @return File|null
     */
    public function getFileAssuranceRecto(): ?File
    {
        return $this->fileAssuranceRecto;
    }
    /**
     * @return File|null
     */
    public function getFileAssuranceVerso(): ?File
    {
        return $this->fileAssuranceVerso;
    }

    /**
     * @param File|null $file
     *
     */
    public function setFile(?File $file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @param File|null $file
     *
     */
    public function setFilePieceVerso(?File $file)
    {
        $this->filePieceVerso = $file;
        return $this;
    }

    /**
     * @param File|null $file
     *
     */
    public function setFileAssuranceRecto(?File $file)
    {
        $this->fileAssuranceRecto = $file;
        return $this;
    }

    /**
     * @param File|null $file
     *
     */
    public function setFileAssuranceVerso(?File $file)
    {
        $this->fileAssuranceVerso = $file;
        return $this;
    }


    /**
     *
     * @Groups({"assures_read","familles_read"})
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"assures_read","patient_read","famille_read"})
     */
    private $pieceIdRecto;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"assures_read","patient_read","famille_read"})
     */
    private $pieceIdVerso;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"assures_read","patient_read","famille_read"})
     */
    private $assuranceRecto;



    public function getPieceIdRecto(): ?string
    {
        return $this->pieceIdRecto;
    }

    public function setPieceIdRecto(?string $pieceIdRecto): self
    {
        $this->pieceIdRecto = $pieceIdRecto;

        return $this;
    }

    public function getPieceIdVerso(): ?string
    {
        return $this->pieceIdVerso;
    }

    public function setPieceIdVerso(?string $pieceIdVerso): self
    {
        $this->pieceIdVerso = $pieceIdVerso;

        return $this;
    }

    public function getAssuranceRecto(): ?string
    {
        return $this->assuranceRecto;
    }

    public function setAssuranceRecto(?string $assuranceRecto): self
    {
        $this->assuranceRecto = $assuranceRecto;

        return $this;
    }

    public function getAssuranceVerso(): ?string
    {
        return $this->assuranceVerso;
    }

    public function setAssuranceVerso(?string $assuranceVerso): self
    {
        $this->assuranceVerso = $assuranceVerso;

        return $this;
    }

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @Groups({"assures_read","patient_read"})
     */
    private $assuranceVerso;


    /**
     * @ORM\Column(type="string", length=180)
     *  @Groups({"assures_read","patient_read","famille_read"})
     * @Assert\Email(message="Nous avons besoin de votre email")
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string",nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read","patient_read","famille_read"})
     */
    private $prenoms;

    /**
     *  @Groups({"assures_read","patient_read","famille_read"})
     * @ORM\ManyToOne(targetEntity=Assurance::class, inversedBy="assures")
     */
    private $assurance;

    /**
     *
     * @ORM\OneToMany(targetEntity=Ordonnance::class, mappedBy="assure")
     */
    private $ordonnances;

    /**
     *
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="concerne")
     */
    private $rendezVouses;

    /**
     * @ORM\Column(type="string", length=12,  unique=true)
     *  @Groups({"assures_read","patient_read","famille_read"})
     * @Assert\NotBlank(message="Nous avons besoin de votre numéro de telephone")
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $tel2;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $fcmtoken;

    /**
     * @ORM\Column(type="float")
     * @Groups({"assures_read","patient_read","famille_read"})
     */
    private $tauxCouverture;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $autreAntecedent;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $numeroAssure;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read","patient_read","famille_read"})
     */
    private $lieuHabitation;

    /**
     * @ORM\Column(type="date", nullable=true)
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $dateNaissance;

    /**
     * @ORM\OneToMany(targetEntity=Adresse::class, mappedBy="assure")
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $adresses;

    /**
     * @ORM\Column(type="datetime")
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $version;

    /**
     * @ORM\Column(type="boolean")
     *  @Groups({"assures_read","patient_read","famille_read"})
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity=Facture::class, mappedBy="assure")
     *
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

    /**
     * @ORM\OneToMany(targetEntity=Livraison::class, mappedBy="assure")
     *
     */
    private $livraisons;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="assure")
     *
     */
    private $notifications;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"assures_read"})
     */
    private $profession;


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
        $this->livraisons = new ArrayCollection();
        $this->notifications = new ArrayCollection();
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

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
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

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setAssure($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getAssure() === $this) {
                $livraison->setAssure(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Notification>
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setAssure($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getAssure() === $this) {
                $notification->setAssure(null);
            }
        }

        return $this;
    }

    public function getProfession(): ?string
    {
        return $this->profession;
    }

    public function setProfession(string $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

}
