<?php

namespace App\Controller;

use App\Entity\Dette;
use App\Repository\DetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    #[Route('/dette/details/{id}', name: 'dette.showDetails', methods: ['GET'])]
    public function showDetails(DetteRepository $detteRepository, int $id): Response
    {
        $dette = $detteRepository->findDetteWithArticles($id); 
        if (!$dette) {
            throw $this->createNotFoundException('Aucune dette trouvée pour cet ID.');
        }
        return $this->render('dette/details.html.twig', [
            'dette' => $dette
        ]);
    }
    
}
