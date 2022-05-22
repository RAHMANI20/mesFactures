<?php

namespace App\Entity;

use App\Repository\PreferenceDepositRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceDepositRepository::class)]
class PreferenceDeposit
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

    #[ORM\Column(type: 'float', nullable: true)]
    private $montant_payer;

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

    public function getMontantPayer(): ?float
    {
        return $this->montant_payer;
    }

    public function setMontantPayer(?float $montant_payer): self
    {
        $this->montant_payer = $montant_payer;

        return $this;
    }
}
