<?php

namespace App\Entity;

use App\Repository\QuotationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\This;

#[ORM\Entity(repositoryClass: QuotationRepository::class)]
class Quotation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;



    #[ORM\Column(type: 'integer')]
    private $duree_validite;

    #[ORM\Column(type: 'string', length: 40)]
    private $devise;

    #[ORM\OneToMany(mappedBy: 'quotation', targetEntity: Article::class,cascade: ['persist'])]
    private $articles;

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

    #[ORM\Column(type: 'text', nullable: true)]
    private $conditions_generales;

    #[ORM\Column(type: 'string', length: 30)]
    private $state;

    #[ORM\Column(type: 'boolean')]
    private $tva_non_applicable;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $last_update;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private $numerotation;

    #[ORM\Column(type: 'date', nullable: true)]
    private $signed_at;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $finalization_at;

    #[ORM\ManyToOne(targetEntity: BusinessClient::class, inversedBy: 'quotations')]
    private $businessClient;

    #[ORM\ManyToOne(targetEntity: ParticularClient::class, inversedBy: 'quotations')]
    private $particularClient;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'quotations')]
    private $company;

    #[ORM\OneToMany(mappedBy: 'quotation', targetEntity: Deposit::class, orphanRemoval: true)]
    private $deposits;



    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->state = "provisoire";
        $this->created_at = new \DateTime('now');
        $this->last_update = new \DateTime('now');
        $this->deposits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }



    public function getDureeValidite(): ?int
    {
        return $this->duree_validite;
    }

    public function setDureeValidite(int $duree_validite): self
    {
        $this->duree_validite = $duree_validite;

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
            $article->setQuotation($this);
        }


        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getQuotation() === $this) {
                $article->setQuotation(null);
            }
        }

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

    public function getConditionsGenerales(): ?string
    {
        return $this->conditions_generales;
    }

    public function setConditionsGenerales(?string $conditions_generales): self
    {
        $this->conditions_generales = $conditions_generales;

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

    public function getTvaNonApplicable(): ?bool
    {
        return $this->tva_non_applicable;
    }

    public function setTvaNonApplicable(bool $tva_non_applicable): self
    {
        $this->tva_non_applicable = $tva_non_applicable;

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

    public function getNumerotation(): ?string
    {
        return $this->numerotation;
    }

    public function setNumerotation(?string $numerotation): self
    {
        $this->numerotation = $numerotation;

        return $this;
    }

    public function getSignedAt(): ?\DateTimeInterface
    {
        return $this->signed_at;
    }

    public function setSignedAt(?\DateTimeInterface $signed_at): self
    {
        $this->signed_at = $signed_at;

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

    /**
     * @return Collection<int, Deposit>
     */
    public function getDeposits(): Collection
    {
        return $this->deposits;
    }

    public function addDeposit(Deposit $deposit): self
    {
        if (!$this->deposits->contains($deposit)) {
            $this->deposits[] = $deposit;
            $deposit->setQuotation($this);
        }

        return $this;
    }

    public function removeDeposit(Deposit $deposit): self
    {
        if ($this->deposits->removeElement($deposit)) {
            // set the owning side to null (unless already changed)
            if ($deposit->getQuotation() === $this) {
                $deposit->setQuotation(null);
            }
        }

        return $this;
    }
//
//    public function __toString(): string
//    {
//        return $this->numerotation;
//    }




}
