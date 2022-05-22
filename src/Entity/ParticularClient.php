<?php

namespace App\Entity;

use App\Repository\ParticularClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticularClientRepository::class)]
class ParticularClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private $email;

    #[ORM\Column(type: 'string', length: 100)]
    private $prenom;

    #[ORM\Column(type: 'string', length: 100)]
    private $nom;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $fonction;

    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'particularClients')]
    #[ORM\JoinColumn(nullable: false)]
    private $langue;

    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private $complement_adresse;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private $code_postal;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $ville;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $pays;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $site_internet;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $num_telephone;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\OneToMany(mappedBy: 'particularClient', targetEntity: Quotation::class)]
    private $quotations;

    #[ORM\OneToMany(mappedBy: 'particularClient', targetEntity: Bill::class)]
    private $bills;

    #[ORM\OneToMany(mappedBy: 'particularClient', targetEntity: BillCredit::class)]
    private $billCredits;

    #[ORM\OneToMany(mappedBy: 'particularClient', targetEntity: Opportunity::class)]
    private $opportunities;

    public function __construct()
    {
        $this->created_at = new \DateTime('now');
        $this->quotations = new ArrayCollection();
        $this->bills = new ArrayCollection();
        $this->billCredits = new ArrayCollection();
        $this->opportunities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(?string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getLangue(): ?Language
    {
        return $this->langue;
    }

    public function setLangue(?Language $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getComplementAdresse(): ?string
    {
        return $this->complement_adresse;
    }

    public function setComplementAdresse(?string $complement_adresse): self
    {
        $this->complement_adresse = $complement_adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getSiteInternet(): ?string
    {
        return $this->site_internet;
    }

    public function setSiteInternet(?string $site_internet): self
    {
        $this->site_internet = $site_internet;

        return $this;
    }

    public function getNumTelephone(): ?string
    {
        return $this->num_telephone;
    }

    public function setNumTelephone(?string $num_telephone): self
    {
        $this->num_telephone = $num_telephone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function __toString(): string
    {
        return $this->prenom." ".$this->nom;
    }

    /**
     * @return Collection<int, Quotation>
     */
    public function getQuotations(): Collection
    {
        return $this->quotations;
    }

    public function addQuotation(Quotation $quotation): self
    {
        if (!$this->quotations->contains($quotation)) {
            $this->quotations[] = $quotation;
            $quotation->setParticularClient($this);
        }

        return $this;
    }

    public function removeQuotation(Quotation $quotation): self
    {
        if ($this->quotations->removeElement($quotation)) {
            // set the owning side to null (unless already changed)
            if ($quotation->getParticularClient() === $this) {
                $quotation->setParticularClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bill>
     */
    public function getBills(): Collection
    {
        return $this->bills;
    }

    public function addBill(Bill $bill): self
    {
        if (!$this->bills->contains($bill)) {
            $this->bills[] = $bill;
            $bill->setParticularClient($this);
        }

        return $this;
    }

    public function removeBill(Bill $bill): self
    {
        if ($this->bills->removeElement($bill)) {
            // set the owning side to null (unless already changed)
            if ($bill->getParticularClient() === $this) {
                $bill->setParticularClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BillCredit>
     */
    public function getBillCredits(): Collection
    {
        return $this->billCredits;
    }

    public function addBillCredit(BillCredit $billCredit): self
    {
        if (!$this->billCredits->contains($billCredit)) {
            $this->billCredits[] = $billCredit;
            $billCredit->setParticularClient($this);
        }

        return $this;
    }

    public function removeBillCredit(BillCredit $billCredit): self
    {
        if ($this->billCredits->removeElement($billCredit)) {
            // set the owning side to null (unless already changed)
            if ($billCredit->getParticularClient() === $this) {
                $billCredit->setParticularClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Opportunity>
     */
    public function getOpportunities(): Collection
    {
        return $this->opportunities;
    }

    public function addOpportunity(Opportunity $opportunity): self
    {
        if (!$this->opportunities->contains($opportunity)) {
            $this->opportunities[] = $opportunity;
            $opportunity->setParticularClient($this);
        }

        return $this;
    }

    public function removeOpportunity(Opportunity $opportunity): self
    {
        if ($this->opportunities->removeElement($opportunity)) {
            // set the owning side to null (unless already changed)
            if ($opportunity->getParticularClient() === $this) {
                $opportunity->setParticularClient(null);
            }
        }

        return $this;
    }
}
