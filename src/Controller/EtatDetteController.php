<?php

namespace App\Controller;

use App\Repository\EtatDetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EtatDetteController extends AbstractController
{
    #[Route('/etatDette', name: 'etatDette.index')]
    public function index(EtatDetteRepository $etatDetteRepository): Response
    {
        $etatDettes = $etatDetteRepository->findAll();

        return $this->render('etatDette/index.html.twig', [
            'datas' => $etatDettes,
        ]);
    }
}
