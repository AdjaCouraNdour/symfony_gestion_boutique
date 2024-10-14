<?php

namespace App\Entity;

use App\Repository\EtatDetteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtatDetteRepository::class)]
class EtatDette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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
