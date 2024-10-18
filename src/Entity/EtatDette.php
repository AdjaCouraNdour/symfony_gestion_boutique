<?php

namespace App\Entity;

enum EtatDette: string
{
    case enCours = 'En_Cours';
    case annule = 'Annule';
}