<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100)]
    private ?string $reference = null;

    #[ORM\Column(type: "string", length: 100)]
    private ?string $libelle = null;
    
    #[ORM\Column(type: "decimal", precision: 15, scale: 2)]
    private ?float $qte_stock = null; 
    
    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private ?float $prix = null; 
    
    #[ORM\Column(type: "string", length: 100)] 
    private ?etatArticle $etat = null; 

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getReference(): ?string
    {
        return $this->reference;
    }
    
    public function setReference(string $reference): self
    {
        $this->reference = $reference;    
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
    
    public function getQteStock(): ?float
    {
        return $this->qte_stock;
    }
    
    public function setQteStock(float $qte_stock): self
    {
        $this->qte_stock = $qte_stock;
        return $this;
    }
    
    public function getPrix(): ?float
    {
        return $this->prix;
    }
    
    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getEtat(): ?etatArticle 
    {
        return $this->etat;
    }
    
    public function setEtat(etatArticle $etat): self 
    {
        $this->etat = $etat;
        return $this;
    }
}
