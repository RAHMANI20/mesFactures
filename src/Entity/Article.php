<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $quantite;

    #[ORM\Column(type: 'float', nullable: true)]
    private $prix_ht;

    #[ORM\Column(type: 'float', nullable: true)]
    private $tva;

    #[ORM\Column(type: 'float', nullable: true)]
    private $reduction;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\ManyToOne(targetEntity: Quotation::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: true)]
    private $quotation;

    #[ORM\ManyToOne(targetEntity: Bill::class, inversedBy: 'articles')]
    private $bill;

    #[ORM\ManyToOne(targetEntity: TypeArticle::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private $type_article;

    #[ORM\ManyToOne(targetEntity: BillCredit::class, inversedBy: 'articles')]
    private $billCredit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(?string $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixHt(): ?float
    {
        return $this->prix_ht;
    }

    public function setPrixHt(?float $prix_ht): self
    {
        $this->prix_ht = $prix_ht;

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

    public function getReduction(): ?float
    {
        return $this->reduction;
    }

    public function setReduction(?float $reduction): self
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
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

    public function calculTotalHt(){
        return ($this->prix_ht*$this->quantite) - ((($this->reduction*$this->prix_ht)/100)*$this->quantite);
    }

    public function calculTva(){
        return ($this->calculTotalHt()*$this->tva)/100;
    }

    public function getBill(): ?Bill
    {
        return $this->bill;
    }

    public function setBill(?Bill $bill): self
    {
        $this->bill = $bill;

        return $this;
    }

    public function getTypeArticle(): ?TypeArticle
    {
        return $this->type_article;
    }

    public function setTypeArticle(?TypeArticle $type_article): self
    {
        $this->type_article = $type_article;

        return $this;
    }

    public function getBillCredit(): ?BillCredit
    {
        return $this->billCredit;
    }

    public function setBillCredit(?BillCredit $billCredit): self
    {
        $this->billCredit = $billCredit;

        return $this;
    }


}
