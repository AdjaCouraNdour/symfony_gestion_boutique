<?php

namespace App\Entity;

enum TypeDette: string
{
    case solde = 'solde';
    case nonSolde = 'non_solde';
}