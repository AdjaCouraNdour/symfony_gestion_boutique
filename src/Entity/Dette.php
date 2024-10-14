<?php

namespace App\Entity;

use App\Repository\DetteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetteRepository::class)]
class Dette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    
    #[ORM\Column(type: "float", precision: 15, scale: 2)]
    private ?float $montant = null; 
    
    #[ORM\Column(type: "float", precision: 10, scale: 2)]
    private ?float $montantVerse = null;

    #[ORM\Column(type: "float", precision: 10, scale: 2 , nullable: true)]
    private ?float $montantRestant = null;


    #[ORM\ManyToOne(targetEntity: TypeDette::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeDette $type = null;  

    #[ORM\ManyToOne(targetEntity: EtatDette::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?EtatDette $etat = null;

    #[ORM\ManyToOne(inversedBy: 'dettes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null; 

    #[ORM\Column]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updateAt = null;

    public function getMontant(): ?float
    {
        return $this->montant;
    }
    
    public function setMontant(float $montant): self
    {
        $this->montant = $montant;
        return $this;
    }

    public function getMontantVerse(): ?float
    {
        return $this->montantVerse;
    }
    
    public function setMontantVerse(float $montantVerse): self
    {
        $this->montantVerse = $montantVerse;
        return $this;
    }

    public function getMontantRestant(): ?float
    {
        return $this->montantRestant;
    }
    
    public function setMontantRestant(float $montantRestant): self
    {
        $this->montantRestant = $montantRestant;
        return $this;
    }

    public function getType(): ?TypeDette 
    {
        return $this->type;
    }

    public function setType(TypeDette $type): self 
    {
        $this->type = $type;
        return $this;
    }

    public function getEtat(): ?EtatDette 
    {
        return $this->etat;
    }
    
    public function setEtat(EtatDette $etat): self 
    {
        $this->etat = $etat;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;
        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }
}
