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
    private function paginate(EntityManagerInterface $entityManager, string $entityClass, Request $request, int $limit = 3): array
    {
        $page = $request->query->getInt('page', 1);
        $offset = ($page - 1) * $limit;
        $entities = $entityManager->getRepository($entityClass)->findBy([], null, $limit, $offset);
        $totalEntities = count($entityManager->getRepository($entityClass)->findAll());
        $totalPages = ceil($totalEntities / $limit);

        return [$entities, $totalPages, $page];
    }

    #[Route('/client', name: 'client.index', methods:['GET'])]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        [$clients, $totalPages, $page] = $this->paginate($entityManager, Client::class, $request);
        
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);

    }

    #[Route('/client/store', name: 'client.store', methods:['GET','POST'])]
    public function store(): Response
    {
        $clients = $entityManager->getRepository(Client::class)->findAll();
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }

    //path variable 
    //$_request : injonction de dependance
    #[Route('/client/show/{id?}', name: 'client.show', methods:['GET'])]
    public function show(int $id,EntityManagerInterface $entityManager, Request $request): Response
    {
        [$clients, $totalPages, $page] = $this->paginate($entityManager, Client::class, $request);
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'currentPage' => $page,
            'totalPages' => $totalPages,        
        ]);
    }

    //query params
    #[Route('/client/search/telephone', name: 'client.searchClientByTelephone', methods:['GET'])]
    public function searchClientByTelephone(EntityManagerInterface $entityManager, Request $request): Response
    {
        $telephone=$request->query->get('tel');
        [$clients, $totalPages, $page] = $this->paginate($entityManager, Client::class, $request);
        return $this->render('client/index.html.twig', [
            'clients' => $clients,
            'currentPage' => $page,
            'totalPages' => $totalPages,        
        ]);
    }

    #[Route('/client/remove/{id?}', name: 'client.remove', methods:['GET'])]
    public function remove(int $id,EntityManagerInterface $entityManager, Request $request): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clients,     
        ]);
    }
  
}
