<?php

namespace App\Controller;

use App\Repository\UserRoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserRoleController extends AbstractController
{
    #[Route('/userRole', name: 'userRole.index')]
    public function index(UserRoleRepository $userRoleRepository): Response
    {
        $userRoles = $userRoleRepository->findAll();

        return $this->render('userRole/index.html.twig', [
            'userRoles' => $userRoles,
        ]);
    }
}
