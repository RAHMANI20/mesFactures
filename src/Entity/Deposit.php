<?php

namespace App\Entity;

use App\Repository\DepositRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepositRepository::class)]
class Deposit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Quotation::class, inversedBy: 'deposits')]
    #[ORM\JoinColumn(nullable: false)]
    private $quotation;

    #[ORM\Column(type: 'float')]
    private $montant_payer;

    #[ORM\Column(type: 'boolean')]
    private $tva_non_applicable;

    #[ORM\Column(type: 'float', nullable: true)]
    private $tva;

    #[ORM\Column(type: 'string', length: 30)]
    private $condition_reglement;

    #[ORM\Column(type: 'string', length: 40)]
    private $mode_reglement;

    #[ORM\Column(type: 'string', length: 40)]
    private $interet_retard;

    #[ORM\ManyToOne(targetEntity: BankAccount::class, inversedBy: 'deposits')]
    private $compte_bancaire;

    #[ORM\Column(type: 'text', nullable: true)]
    private $text_introduction;

    #[ORM\Column(type: 'text', nullable: true)]
    private $text_conclusion;

    #[ORM\Column(type: 'text', nullable: true)]
    private $pied_page;

    #[ORM\Column(type: 'string', length: 30)]
    private $state;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $last_update;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $finalization_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $payed_at;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private $numerotation;

    public function __construct()
    {
        $this->state = "provisoire";
        $this->created_at = new \DateTime('now');
        $this->last_update = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuotation(): ?Quotation
    {
        return $this->quotation;
    }

    public function setQuotation(?Quotation $quotation): self
    {
        $this->quotation = $quotation;

        return $this;
    }

    public function getMontantPayer(): ?string
    {
        return $this->montant_payer;
    }

    public function setMontantPayer(string $montant_payer): self
    {
        $this->montant_payer = $montant_payer;

        return $this;
    }

    public function getTvaNonApplicable(): ?bool
    {
        return $this->tva_non_applicable;
    }

    public function setTvaNonApplicable(bool $tva_non_applicable): self
    {
        $this->tva_non_applicable = $tva_non_applicable;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getConditionReglement(): ?string
    {
        return $this->condition_reglement;
    }

    public function setConditionReglement(string $condition_reglement): self
    {
        $this->condition_reglement = $condition_reglement;

        return $this;
    }

    public function getModeReglement(): ?string
    {
        return $this->mode_reglement;
    }

    public function setModeReglement(string $mode_reglement): self
    {
        $this->mode_reglement = $mode_reglement;

        return $this;
    }

    public function getInteretRetard(): ?string
    {
        return $this->interet_retard;
    }

    public function setInteretRetard(string $interet_retard): self
    {
        $this->interet_retard = $interet_retard;

        return $this;
    }

    public function getCompteBancaire(): ?BankAccount
    {
        return $this->compte_bancaire;
    }

    public function setCompteBancaire(?BankAccount $compte_bancaire): self
    {
        $this->compte_bancaire = $compte_bancaire;

        return $this;
    }

    public function getTextIntroduction(): ?string
    {
        return $this->text_introduction;
    }

    public function setTextIntroduction(?string $text_introduction): self
    {
        $this->text_introduction = $text_introduction;

        return $this;
    }

    public function getTextConclusion(): ?string
    {
        return $this->text_conclusion;
    }

    public function setTextConclusion(?string $text_conclusion): self
    {
        $this->text_conclusion = $text_conclusion;

        return $this;
    }

    public function getPiedPage(): ?string
    {
        return $this->pied_page;
    }

    public function setPiedPage(?string $pied_page): self
    {
        $this->pied_page = $pied_page;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

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

    public function getLastUpdate(): ?\DateTimeInterface
    {
        return $this->last_update;
    }

    public function setLastUpdate(\DateTimeInterface $last_update): self
    {
        $this->last_update = $last_update;

        return $this;
    }

    public function getFinalizationAt(): ?\DateTimeInterface
    {
        return $this->finalization_at;
    }

    public function setFinalizationAt(?\DateTimeInterface $finalization_at): self
    {
        $this->finalization_at = $finalization_at;

        return $this;
    }

    public function getPayedAt(): ?\DateTimeInterface
    {
        return $this->payed_at;
    }

    public function setPayedAt(?\DateTimeInterface $payed_at): self
    {
        $this->payed_at = $payed_at;

        return $this;
    }

    public function calculPourCentAgeAcompte(){
        return round(($this->montant_payer*100)/$this->quotation->calculTtc(),0);
    }

    public function calculMontant(){
        return round($this->montant_payer/(1+($this->tva/100)),2);
    }

    public function getNumerotation(): ?string
    {
        return $this->numerotation;
    }

    public function setNumerotation(?string $numerotation): self
    {
        $this->numerotation = $numerotation;

        return $this;
    }


}
