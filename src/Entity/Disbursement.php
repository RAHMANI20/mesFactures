<?php

namespace App\Entity;

use App\Repository\DisbursementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisbursementRepository::class)]
class Disbursement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $reference_facture;

    #[ORM\Column(type: 'float')]
    private $montant_ht;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\ManyToOne(targetEntity: Bill::class, inversedBy: 'disbursements')]
    private $bill;

    #[ORM\ManyToOne(targetEntity: BillCredit::class, inversedBy: 'disbursements')]
    private $billCredit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReferenceFacture(): ?string
    {
        return $this->reference_facture;
    }

    public function setReferenceFacture(?string $reference_facture): self
    {
        $this->reference_facture = $reference_facture;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
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
