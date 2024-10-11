<?php

namespace App\Controller;

use App\Entity\Demande;  
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DemandeController extends AbstractController
{
    #[Route('/demande', name: 'app_demande')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $demandes = $entityManager->getRepository(Demande::class)->findAll();
        
        return $this->render('demande/index.html.twig', [
            'demandes' => $demandes,
        ]);
    }
}