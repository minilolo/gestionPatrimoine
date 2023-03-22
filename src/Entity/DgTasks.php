<?php

namespace App\Entity;

use App\Repository\DgTasksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DgTasksRepository::class)]
class DgTasks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?bool $ad = null;

    #[ORM\Column]
    private ?bool $prmp = null;

    #[ORM\Column]
    private ?bool $daj = null;

    #[ORM\Column]
    private ?bool $daf = null;

    #[ORM\Column]
    private ?bool $snd = null;

    #[ORM\Column]
    private ?bool $srha = null;

    #[ORM\Column]
    private ?bool $scofi = null;

    #[ORM\Column]
    private ?bool $sad = null;

    #[ORM\Column]
    private ?bool $suiteADonner = null;

    #[ORM\Column]
    private ?bool $enParlerAuTelephone = null;

    #[ORM\Column]
    private ?bool $venirEnParler = null;

    #[ORM\Column]
    private ?bool $prospectionDeCandidature = null;

    #[ORM\Column]
    private ?bool $avis = null;

    #[ORM\Column]
    private ?bool $garderEnInstance = null;

    #[ORM\Column]
    private ?bool $enFaireUneNote = null;

    #[ORM\Column]
    private ?bool $affichage = null;

    #[ORM\Column]
    private ?bool $copieAMeRetourner = null;

    #[ORM\Column]
    private ?bool $suivi = null;

    #[ORM\Column]
    private ?bool $attribution = null;

    #[ORM\Column]
    private ?bool $information = null;

    #[ORM\Column]
    private ?bool $rappeler = null;

    #[ORM\Column]
    private ?bool $rendreCompte = null;

    #[ORM\Column]
    private ?bool $procedureASuivre = null;

    #[ORM\Column]
    private ?bool $representer = null;

    #[ORM\Column]
    private ?bool $etudeEtEnParler = null;

    #[ORM\Column]
    private ?bool $classement = null;

    #[ORM\Column]
    private ?bool $remettre = null;

    #[ORM\ManyToOne(inversedBy: 'dgTasks')]
    private ?Client $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function isAd(): ?bool
    {
        return $this->ad;
    }

    public function setAd(bool $ad): self
    {
        $this->ad = $ad;

        return $this;
    }

    public function isPrmp(): ?bool
    {
        return $this->prmp;
    }

    public function setPrmp(bool $prmp): self
    {
        $this->prmp = $prmp;

        return $this;
    }

    public function isDaj(): ?bool
    {
        return $this->daj;
    }

    public function setDaj(bool $daj): self
    {
        $this->daj = $daj;

        return $this;
    }

    public function isDaf(): ?bool
    {
        return $this->daf;
    }

    public function setDaf(bool $daf): self
    {
        $this->daf = $daf;

        return $this;
    }

    public function isSnd(): ?bool
    {
        return $this->snd;
    }

    public function setSnd(bool $snd): self
    {
        $this->snd = $snd;

        return $this;
    }

    public function isSrha(): ?bool
    {
        return $this->srha;
    }

    public function setSrha(bool $srha): self
    {
        $this->srha = $srha;

        return $this;
    }

    public function isScofi(): ?bool
    {
        return $this->scofi;
    }

    public function setScofi(bool $scofi): self
    {
        $this->scofi = $scofi;

        return $this;
    }

    public function isSad(): ?bool
    {
        return $this->sad;
    }

    public function setSad(bool $sad): self
    {
        $this->sad = $sad;

        return $this;
    }

    public function isSuiteADonner(): ?bool
    {
        return $this->suiteADonner;
    }

    public function setSuiteADonner(bool $suiteADonner): self
    {
        $this->suiteADonner = $suiteADonner;

        return $this;
    }

    public function isEnParlerAuTelephone(): ?bool
    {
        return $this->enParlerAuTelephone;
    }

    public function setEnParlerAuTelephone(bool $enParlerAuTelephone): self
    {
        $this->enParlerAuTelephone = $enParlerAuTelephone;

        return $this;
    }

    public function isVenirEnParler(): ?bool
    {
        return $this->venirEnParler;
    }

    public function setVenirEnParler(bool $venirEnParler): self
    {
        $this->venirEnParler = $venirEnParler;

        return $this;
    }

    public function isProspectionDeCandidature(): ?bool
    {
        return $this->prospectionDeCandidature;
    }

    public function setProspectionDeCandidature(bool $prospectionDeCandidature): self
    {
        $this->prospectionDeCandidature = $prospectionDeCandidature;

        return $this;
    }

    public function isAvis(): ?bool
    {
        return $this->avis;
    }

    public function setAvis(bool $avis): self
    {
        $this->avis = $avis;

        return $this;
    }

    public function isGarderEnInstance(): ?bool
    {
        return $this->garderEnInstance;
    }

    public function setGarderEnInstance(bool $garderEnInstance): self
    {
        $this->garderEnInstance = $garderEnInstance;

        return $this;
    }

    public function isEnFaireUneNote(): ?bool
    {
        return $this->enFaireUneNote;
    }

    public function setEnFaireUneNote(bool $enFaireUneNote): self
    {
        $this->enFaireUneNote = $enFaireUneNote;

        return $this;
    }

    public function isAffichage(): ?bool
    {
        return $this->affichage;
    }

    public function setAffichage(bool $affichage): self
    {
        $this->affichage = $affichage;

        return $this;
    }

    public function isCopieAMeRetourner(): ?bool
    {
        return $this->copieAMeRetourner;
    }

    public function setCopieAMeRetourner(bool $copieAMeRetourner): self
    {
        $this->copieAMeRetourner = $copieAMeRetourner;

        return $this;
    }

    public function isSuivi(): ?bool
    {
        return $this->suivi;
    }

    public function setSuivi(bool $suivi): self
    {
        $this->suivi = $suivi;

        return $this;
    }

    public function isAttribution(): ?bool
    {
        return $this->attribution;
    }

    public function setAttribution(bool $attribution): self
    {
        $this->attribution = $attribution;

        return $this;
    }

    public function isInformation(): ?bool
    {
        return $this->information;
    }

    public function setInformation(bool $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function isRappeler(): ?bool
    {
        return $this->rappeler;
    }

    public function setRappeler(bool $rappeler): self
    {
        $this->rappeler = $rappeler;

        return $this;
    }

    public function isRendreCompte(): ?bool
    {
        return $this->rendreCompte;
    }

    public function setRendreCompte(bool $rendreCompte): self
    {
        $this->rendreCompte = $rendreCompte;

        return $this;
    }

    public function isProcedureASuivre(): ?bool
    {
        return $this->procedureASuivre;
    }

    public function setProcedureASuivre(bool $procedureASuivre): self
    {
        $this->procedureASuivre = $procedureASuivre;

        return $this;
    }

    public function isRepresenter(): ?bool
    {
        return $this->representer;
    }

    public function setRepresenter(bool $representer): self
    {
        $this->representer = $representer;

        return $this;
    }

    public function isEtudeEtEnParler(): ?bool
    {
        return $this->etudeEtEnParler;
    }

    public function setEtudeEtEnParler(bool $etudeEtEnParler): self
    {
        $this->etudeEtEnParler = $etudeEtEnParler;

        return $this;
    }

    public function isClassement(): ?bool
    {
        return $this->classement;
    }

    public function setClassement(bool $classement): self
    {
        $this->classement = $classement;

        return $this;
    }

    public function isRemettre(): ?bool
    {
        return $this->remettre;
    }

    public function setRemettre(bool $remettre): self
    {
        $this->remettre = $remettre;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
