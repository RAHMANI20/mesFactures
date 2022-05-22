<?php

namespace App\Entity;

use App\Repository\PreferenceQuotationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceQuotationRepository::class)]
class PreferenceQuotation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text', nullable: true)]
    private $text_introduction;

    #[ORM\Column(type: 'text', nullable: true)]
    private $text_conclusion;

    #[ORM\Column(type: 'text', nullable: true)]
    private $pied_page;

    #[ORM\Column(type: 'text', nullable: true)]
    private $conditions_generales;

    public function getId(): ?int
    {
        return $this->id;
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
}
