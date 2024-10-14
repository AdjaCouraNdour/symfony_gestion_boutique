<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user.index')]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        
        return $this->render('user/index.html.twig', [
            'datas' => $users,
        ]);
    }
}