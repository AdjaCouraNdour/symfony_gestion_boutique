<?php

namespace App\Entity;

enum UserRole: string
{
    case roleBoutiquier = 'Boutiquier';
    case roleClient = 'Client';
}
