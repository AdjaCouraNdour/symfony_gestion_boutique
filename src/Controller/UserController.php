<?php

namespace App\Controller;

use App\Entity\User;  
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
}