<?php

// src/Controller/ClientController.php

namespace App\Controller;

use App\Entity\Client;  
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        // Nombre de clients par page
        $limit = 3;
        // Numéro de la page actuelle, par défaut à 1
        $page = $request->query->getInt('page', 1);
        // Calcul de l'offset pour la base de données
        $offset = ($page - 1) * $limit;
        // Récupérer les clients paginés
        $clients = $entityManager->getRepository(Client::class)->findBy([], null, $limit, $offset);
        // Récupérer le nombre total de clients
        $totalClients = count($entityManager->getRepository(Client::class)->findAll());
        $totalPages = ceil($totalClients / $limit);

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
