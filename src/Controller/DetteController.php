<?php

namespace App\Controller;

use App\Entity\Dette;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DetteController extends AbstractController
{
    #[Route('/dette', name: 'dette.index')]
    public function index(DetteRepository $detteRepository): Response
    {
        $dettes = $detteRepository->findAll();
        
        return $this->render('dette/index.html.twig', [
            'datas' => $dettes,
        ]);
    }
}