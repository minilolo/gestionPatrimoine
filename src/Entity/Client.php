<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birth_date = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_insertion = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Recu::class)]
    private Collection $recus;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: PdfEntity::class)]
    private Collection $pdfEntities;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: PointDeDossier::class)]
    private Collection $pointDeDossiers;

    #[ORM\Column(length: 255)]
    private ?string $montant = null;

    #[ORM\Column(length: 255)]
    private ?string $total = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Action::class)]
    private Collection $actions;

    #[ORM\Column(length: 100)]
    private ?string $origin = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Courrier::class)]
    private Collection $courriers;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Entrer::class)]
    private Collection $entrers;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: DgTasks::class)]
    private Collection $dgTasks;

    public function __construct()
    {
        $this->recus = new ArrayCollection();
        $this->pdfEntities = new ArrayCollection();
        $this->pointDeDossiers = new ArrayCollection();
        $this->actions = new ArrayCollection();
        $this->courriers = new ArrayCollection();
        $this->entrers = new ArrayCollection();
        $this->dgTasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birth_date;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): self
    {
        $this->birth_date = $birth_date;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDateInsertion(): ?\DateTimeInterface
    {
        return $this->date_insertion;
    }

    public function setDateInsertion(\DateTimeInterface $date_insertion): self
    {
        $this->date_insertion = $date_insertion;

        return $this;
    }

    /**
     * @return Collection<int, Recu>
     */
    public function getRecus(): Collection
    {
        return $this->recus;
    }

    public function addRecu(Recu $recu): self
    {
        if (!$this->recus->contains($recu)) {
            $this->recus->add($recu);
            $recu->setClient($this);
        }

        return $this;
    }

    public function removeRecu(Recu $recu): self
    {
        if ($this->recus->removeElement($recu)) {
            // set the owning side to null (unless already changed)
            if ($recu->getClient() === $this) {
                $recu->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PdfEntity>
     */
    public function getPdfEntities(): Collection
    {
        return $this->pdfEntities;
    }

    public function addPdfEntity(PdfEntity $pdfEntity): self
    {
        if (!$this->pdfEntities->contains($pdfEntity)) {
            $this->pdfEntities->add($pdfEntity);
            $pdfEntity->setClient($this);
        }

        return $this;
    }

    public function removePdfEntity(PdfEntity $pdfEntity): self
    {
        if ($this->pdfEntities->removeElement($pdfEntity)) {
            // set the owning side to null (unless already changed)
            if ($pdfEntity->getClient() === $this) {
                $pdfEntity->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PointDeDossier>
     */
    public function getPointDeDossiers(): Collection
    {
        return $this->pointDeDossiers;
    }

    public function addPointDeDossier(PointDeDossier $pointDeDossier): self
    {
        if (!$this->pointDeDossiers->contains($pointDeDossier)) {
            $this->pointDeDossiers->add($pointDeDossier);
            $pointDeDossier->setClient($this);
        }

        return $this;
    }

    public function removePointDeDossier(PointDeDossier $pointDeDossier): self
    {
        if ($this->pointDeDossiers->removeElement($pointDeDossier)) {
            // set the owning side to null (unless already changed)
            if ($pointDeDossier->getClient() === $this) {
                $pointDeDossier->setClient(null);
            }
        }

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(string $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Action>
     */
    public function getActions(): Collection
    {
        return $this->actions;
    }

    public function addAction(Action $action): self
    {
        if (!$this->actions->contains($action)) {
            $this->actions->add($action);
            $action->setClient($this);
        }

        return $this;
    }

    public function removeAction(Action $action): self
    {
        if ($this->actions->removeElement($action)) {
            // set the owning side to null (unless already changed)
            if ($action->getClient() === $this) {
                $action->setClient(null);
            }
        }

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @return Collection<int, Courrier>
     */
    public function getCourriers(): Collection
    {
        return $this->courriers;
    }

    public function addCourrier(Courrier $courrier): self
    {
        if (!$this->courriers->contains($courrier)) {
            $this->courriers->add($courrier);
            $courrier->setClient($this);
        }

        return $this;
    }

    public function removeCourrier(Courrier $courrier): self
    {
        if ($this->courriers->removeElement($courrier)) {
            // set the owning side to null (unless already changed)
            if ($courrier->getClient() === $this) {
                $courrier->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Entrer>
     */
    public function getEntrers(): Collection
    {
        return $this->entrers;
    }

    public function addEntrer(Entrer $entrer): self
    {
        if (!$this->entrers->contains($entrer)) {
            $this->entrers->add($entrer);
            $entrer->setClient($this);
        }

        return $this;
    }

    public function removeEntrer(Entrer $entrer): self
    {
        if ($this->entrers->removeElement($entrer)) {
            // set the owning side to null (unless already changed)
            if ($entrer->getClient() === $this) {
                $entrer->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, DgTasks>
     */
    public function getDgTasks(): Collection
    {
        return $this->dgTasks;
    }

    public function addDgTask(DgTasks $dgTask): self
    {
        if (!$this->dgTasks->contains($dgTask)) {
            $this->dgTasks->add($dgTask);
            $dgTask->setClient($this);
        }

        return $this;
    }

    public function removeDgTask(DgTasks $dgTask): self
    {
        if ($this->dgTasks->removeElement($dgTask)) {
            // set the owning side to null (unless already changed)
            if ($dgTask->getClient() === $this) {
                $dgTask->setClient(null);
            }
        }

        return $this;
    }
}
