<?php

namespace App\Controller;

use App\Entity\Dette;  
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DetteController extends AbstractController
{
    #[Route('/dette', name: 'app_dette')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $dettes = $entityManager->getRepository(Dette::class)->findAll();
        
        return $this->render('dette/index.html.twig', [
            'dettes' => $dettes,
        ]);
    }
}