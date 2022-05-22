<?php

namespace App\Entity;

use App\Repository\BankAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BankAccountRepository::class)]
class BankAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 27)]
    private $iban;

    #[ORM\Column(type: 'string', length: 12)]
    private $bic;

    #[ORM\Column(type: 'string', length: 50)]
    private $titulaire;

    #[ORM\Column(type: 'string', length: 50)]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'compte_bancaire', targetEntity: Deposit::class)]
    private $deposits;

    #[ORM\OneToMany(mappedBy: 'compte_bancaire', targetEntity: Bill::class)]
    private $bills;

    #[ORM\OneToMany(mappedBy: 'compte_bancaire', targetEntity: BillCredit::class)]
    private $billCredits;

    public function __construct()
    {
        $this->deposits = new ArrayCollection();
        $this->bills = new ArrayCollection();
        $this->billCredits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(string $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    public function getBic(): ?string
    {
        return $this->bic;
    }

    public function setBic(string $bic): self
    {
        $this->bic = $bic;

        return $this;
    }

    public function getTitulaire(): ?string
    {
        return $this->titulaire;
    }

    public function setTitulaire(string $titulaire): self
    {
        $this->titulaire = $titulaire;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $deposit->setCompteBancaire($this);
        }

        return $this;
    }

    public function removeDeposit(Deposit $deposit): self
    {
        if ($this->deposits->removeElement($deposit)) {
            // set the owning side to null (unless already changed)
            if ($deposit->getCompteBancaire() === $this) {
                $deposit->setCompteBancaire(null);
            }
        }

        return $this;
    }

        public function __toString(): string
    {
        return $this->libelle;
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
                $bill->setCompteBancaire($this);
            }

            return $this;
        }

        public function removeBill(Bill $bill): self
        {
            if ($this->bills->removeElement($bill)) {
                // set the owning side to null (unless already changed)
                if ($bill->getCompteBancaire() === $this) {
                    $bill->setCompteBancaire(null);
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
                $billCredit->setCompteBancaire($this);
            }

            return $this;
        }

        public function removeBillCredit(BillCredit $billCredit): self
        {
            if ($this->billCredits->removeElement($billCredit)) {
                // set the owning side to null (unless already changed)
                if ($billCredit->getCompteBancaire() === $this) {
                    $billCredit->setCompteBancaire(null);
                }
            }

            return $this;
        }

}
