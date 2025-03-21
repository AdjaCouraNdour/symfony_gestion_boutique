<?php

namespace App\Entity;

use App\Repository\EtatArticleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatArticleRepository::class)]
class EtatArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; // ID de l'état

    #[ORM\Column(type: "string", length: 100)]
    private ?string $libelle = null; 

    public function getId(): ?int
    {
        return $this->id;
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
}
