<?php

namespace App\Entity;

use App\Repository\BusinessClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BusinessClientRepository::class)]
class BusinessClient
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

    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'businessClients')]
    #[ORM\JoinColumn(nullable: false)]
    private $langue;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $num_telephone;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'businessClients')]
    #[ORM\JoinColumn(nullable: false)]
    private $societe;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\OneToMany(mappedBy: 'businessClient', targetEntity: Quotation::class)]
    private $quotations;

    #[ORM\OneToMany(mappedBy: 'businessClient', targetEntity: Bill::class)]
    private $bills;

    #[ORM\OneToMany(mappedBy: 'businessClient', targetEntity: BillCredit::class)]
    private $billCredits;

    #[ORM\OneToMany(mappedBy: 'businessClient', targetEntity: Opportunity::class)]
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

    public function getNumTelephone(): ?string
    {
        return $this->num_telephone;
    }

    public function setNumTelephone(?string $num_telephone): self
    {
        $this->num_telephone = $num_telephone;

        return $this;
    }

    public function getSociete(): ?Company
    {
        return $this->societe;
    }

    public function setSociete(?Company $societe): self
    {
        $this->societe = $societe;

        return $this;
    }

    public function __toString(): string
    {
        return $this->prenom." ".$this->nom;
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
            $quotation->setBusinessClient($this);
        }

        return $this;
    }

    public function removeQuotation(Quotation $quotation): self
    {
        if ($this->quotations->removeElement($quotation)) {
            // set the owning side to null (unless already changed)
            if ($quotation->getBusinessClient() === $this) {
                $quotation->setBusinessClient(null);
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
            $bill->setBusinessClient($this);
        }

        return $this;
    }

    public function removeBill(Bill $bill): self
    {
        if ($this->bills->removeElement($bill)) {
            // set the owning side to null (unless already changed)
            if ($bill->getBusinessClient() === $this) {
                $bill->setBusinessClient(null);
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
            $billCredit->setBusinessClient($this);
        }

        return $this;
    }

    public function removeBillCredit(BillCredit $billCredit): self
    {
        if ($this->billCredits->removeElement($billCredit)) {
            // set the owning side to null (unless already changed)
            if ($billCredit->getBusinessClient() === $this) {
                $billCredit->setBusinessClient(null);
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
            $opportunity->setBusinessClient($this);
        }

        return $this;
    }

    public function removeOpportunity(Opportunity $opportunity): self
    {
        if ($this->opportunities->removeElement($opportunity)) {
            // set the owning side to null (unless already changed)
            if ($opportunity->getBusinessClient() === $this) {
                $opportunity->setBusinessClient(null);
            }
        }

        return $this;
    }

}
