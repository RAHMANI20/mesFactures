<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    private $langue;

    #[ORM\OneToMany(mappedBy: 'langue', targetEntity: Company::class, orphanRemoval: true)]
    private $companies;

    #[ORM\OneToMany(mappedBy: 'langue', targetEntity: ParticularClient::class, orphanRemoval: true)]
    private $particularClients;

    #[ORM\OneToMany(mappedBy: 'langue', targetEntity: BusinessClient::class, orphanRemoval: true)]
    private $businessClients;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
        $this->particularClients = new ArrayCollection();
        $this->businessClients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->setLangue($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->companies->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getLangue() === $this) {
                $company->setLangue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ParticularClient>
     */
    public function getParticularClients(): Collection
    {
        return $this->particularClients;
    }

    public function addParticularClient(ParticularClient $particularClient): self
    {
        if (!$this->particularClients->contains($particularClient)) {
            $this->particularClients[] = $particularClient;
            $particularClient->setLangue($this);
        }

        return $this;
    }

    public function removeParticularClient(ParticularClient $particularClient): self
    {
        if ($this->particularClients->removeElement($particularClient)) {
            // set the owning side to null (unless already changed)
            if ($particularClient->getLangue() === $this) {
                $particularClient->setLangue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BusinessClient>
     */
    public function getBusinessClients(): Collection
    {
        return $this->businessClients;
    }

    public function addBusinessClient(BusinessClient $businessClient): self
    {
        if (!$this->businessClients->contains($businessClient)) {
            $this->businessClients[] = $businessClient;
            $businessClient->setLangue($this);
        }

        return $this;
    }

    public function removeBusinessClient(BusinessClient $businessClient): self
    {
        if ($this->businessClients->removeElement($businessClient)) {
            // set the owning side to null (unless already changed)
            if ($businessClient->getLangue() === $this) {
                $businessClient->setLangue(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->langue;
    }
}
