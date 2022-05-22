<?php

namespace App\Entity;

use App\Repository\PreferenceGeneralRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceGeneralRepository::class)]
class PreferenceGeneral
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $pays;

    #[ORM\Column(type: 'string', length: 40, nullable: true)]
    private $devise;

    #[ORM\ManyToOne(targetEntity: TypeArticle::class)]
    private $type_article;

    #[ORM\Column(type: 'float', nullable: true)]
    private $tva;

    #[ORM\Column(type: 'boolean')]
    private $tva_non_applicable;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $text_tva;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $condition_reglement;

    #[ORM\Column(type: 'string', length: 40, nullable: true)]
    private $mode_reglement;

    #[ORM\Column(type: 'string', length: 40, nullable: true)]
    private $interet_retard;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(?string $devise): self
    {
        $this->devise = $devise;

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

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): self
    {
        $this->tva = $tva;

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

    public function getTextTva(): ?string
    {
        return $this->text_tva;
    }

    public function setTextTva(?string $text_tva): self
    {
        $this->text_tva = $text_tva;

        return $this;
    }

    public function getConditionReglement(): ?string
    {
        return $this->condition_reglement;
    }

    public function setConditionReglement(?string $condition_reglement): self
    {
        $this->condition_reglement = $condition_reglement;

        return $this;
    }

    public function getModeReglement(): ?string
    {
        return $this->mode_reglement;
    }

    public function setModeReglement(?string $mode_reglement): self
    {
        $this->mode_reglement = $mode_reglement;

        return $this;
    }

    public function getInteretRetard(): ?string
    {
        return $this->interet_retard;
    }

    public function setInteretRetard(?string $interet_retard): self
    {
        $this->interet_retard = $interet_retard;

        return $this;
    }
}
