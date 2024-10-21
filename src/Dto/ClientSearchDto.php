<?php

namespace App\Dto;

use App\Entity\User;
use Doctrine\Inflector\Rules\Pattern;
use Symfony\Component\Validator\Constraints as Assert;

class ClientSearchDto
{
    // #[Assert\Regex(
    //     Pattern:'/^(77|78|76)[0-9]{7}$/',
    //     message:'Entrer un numéro valide (77-XXX-XX-XX, 78-XXX-XX-XX, 76-XXX-XX-XX)',
    // )]
    public String $telephone;
    public String $surname;
    // public User $user;

    public function __construct() {
        $this->telephone = '';
        $this->surname = '';
        // $this->user = null;

    }
}