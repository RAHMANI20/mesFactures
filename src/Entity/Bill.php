<?php

namespace App\Entity;

use App\Repository\BillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BillRepository::class)]
class Bill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 40)]
    private $devise;

    #[ORM\Column(type: 'string', length: 30)]
    private $condition_reglement;

    #[ORM\Column(type: 'string', length: 40)]
    private $mode_reglement;

    #[ORM\Column(type: 'string', length: 40)]
    private $interet_retard;

    #[ORM\Column(type: 'text', nullable: true)]
    private $text_introduction;

    #[ORM\Column(type: 'text', nullable: true)]
    private $text_conclusion;

    #[ORM\Column(type: 'text', nullable: true)]
    private $pied_page;

    #[ORM\ManyToOne(targetEntity: BankAccount::class, inversedBy: 'bills')]
    private $compte_bancaire;

    #[ORM\ManyToOne(targetEntity: BusinessClient::class, inversedBy: 'bills')]
    private $businessClient;

    #[ORM\ManyToOne(targetEntity: ParticularClient::class, inversedBy: 'bills')]
    private $particularClient;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'bills')]
    private $company;

    #[ORM\Column(type: 'boolean')]
    private $tva_non_applicable;

    #[ORM\OneToMany(mappedBy: 'bill', targetEntity: Article::class,cascade: ['persist'])]
    private $articles;

    #[ORM\OneToMany(mappedBy: 'bill', targetEntity: Disbursement::class,cascade: ['persist'])]
    private $disbursements;

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
        $this->articles = new ArrayCollection();
        $this->disbursements = new ArrayCollection();
        $this->state = "provisoire";
        $this->created_at = new \DateTime('now');
        $this->last_update = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCompteBancaire(): ?BankAccount
    {
        return $this->compte_bancaire;
    }

    public function setCompteBancaire(?BankAccount $compte_bancaire): self
    {
        $this->compte_bancaire = $compte_bancaire;

        return $this;
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

    public function getTvaNonApplicable(): ?bool
    {
        return $this->tva_non_applicable;
    }

    public function setTvaNonApplicable(bool $tva_non_applicable): self
    {
        $this->tva_non_applicable = $tva_non_applicable;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setBill($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getBill() === $this) {
                $article->setBill(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Disbursement>
     */
    public function getDisbursements(): Collection
    {
        return $this->disbursements;
    }

    public function setDisbursements($disbursements)
    {
        $this->disbursements = $disbursements;
    }

    public function addDisbursement(Disbursement $disbursement): self
    {
        if (!$this->disbursements->contains($disbursement)) {
            $this->disbursements[] = $disbursement;
            $disbursement->setBill($this);
        }

        return $this;
    }

    public function removeDisbursement(Disbursement $disbursement): self
    {
        if ($this->disbursements->removeElement($disbursement)) {
            // set the owning side to null (unless already changed)
            if ($disbursement->getBill() === $this) {
                $disbursement->setBill(null);
            }
        }

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

    public function calculTotalHt(){
        $totalHt = 0;
        foreach ($this->articles as $article){
            $totalHt = $totalHt + $article->calculTotalHt();
        }
        return $totalHt;
    }

    public function calculTva(){
        $totalTva = 0;
        foreach ($this->articles as $article){
            $totalTva = $totalTva + $article->calculTva();
        }
        return $totalTva;
    }

    public function calculTtc(){
        return $this->calculTotalHt() + $this->calculTva();
    }

    public function calculDebours(){
        $totalDebours = 0;
        foreach ($this->disbursements as $disbursement){
            $totalDebours = $totalDebours + $disbursement->getMontantHt();
        }
        return $totalDebours;
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
