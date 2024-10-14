<?php

namespace App\Controller;

use App\Repository\TypeDetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TypeDetteController extends AbstractController
{
    #[Route('/typeDette', name: 'typeDette.index')]
    public function index(TypeDetteRepository $typeDetteRepository): Response
    {
        $typeDettes = $typeDetteRepository->findAll();

        return $this->render('typeDette/index.html.twig', [
            'datas' => $typeDettes,
        ]);
    }
}
