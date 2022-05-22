<?php

namespace App\Entity;

use App\Repository\OpportunityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpportunityRepository::class)]
class Opportunity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: BusinessClient::class, inversedBy: 'opportunities')]
    private $businessClient;

    #[ORM\ManyToOne(targetEntity: ParticularClient::class, inversedBy: 'opportunities')]
    private $particularClient;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'opportunities')]
    private $company;

    #[ORM\Column(type: 'string', length: 100)]
    private $intitule;

    #[ORM\Column(type: 'float')]
    private $montant_ht;

    #[ORM\Column(type: 'string', length: 40)]
    private $devise;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $mois_signature;

    #[ORM\Column(type: 'string', length: 4, nullable: true)]
    private $annee_signature;

    #[ORM\Column(type: 'integer')]
    private $probabilite;

    #[ORM\Column(type: 'text', nullable: true)]
    private $notes;

    #[ORM\Column(type: 'string', length: 10)]
    private $state;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $last_update;

    public function __construct()
    {

        $this->state = "En cours";
        $this->created_at = new \DateTime('now');
        $this->last_update = new \DateTime('now');
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBusinessClient(): ?BusinessClient
    {
        return $this->businessClient;
    }

    public function setBusinessClient(?BusinessClient $businessClient): self
    {
        $this->businessClient = $businessClient;

        return $this;
    }

    public function getParticularClient(): ?ParticularClient
    {
        return $this->particularClient;
    }

    public function setParticularClient(?ParticularClient $particularClient): self
    {
        $this->particularClient = $particularClient;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function getMontantHt(): ?float
    {
        return $this->montant_ht;
    }

    public function setMontantHt(float $montant_ht): self
    {
        $this->montant_ht = $montant_ht;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(string $devise): self
    {
        $this->devise = $devise;

        return $this;
    }

    public function getMoisSignature(): ?string
    {
        return $this->mois_signature;
    }

    public function setMoisSignature(string $mois_signature): self
    {
        $this->mois_signature = $mois_signature;

        return $this;
    }

    public function getAnneeSignature(): ?string
    {
        return $this->annee_signature;
    }

    public function setAnneeSignature(string $annee_signature): self
    {
        $this->annee_signature = $annee_signature;

        return $this;
    }

    public function getProbabilite(): ?int
    {
        return $this->probabilite;
    }

    public function setProbabilite(int $probabilite): self
    {
        $this->probabilite = $probabilite;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

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
}
