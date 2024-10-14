<?php

// src/Controller/ClientController.php

namespace App\Controller;

use App\Dto\ClientDto;
use App\Form\ClientDtoType;
use App\Entity\Client;  
use App\Repository\ClientRepository; 
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
  
    #[Route('/client', name: 'client.index', methods:['GET'])]
    public function index(ClientRepository $clientRepository, Request $request): Response 
    {
        [$clients, $totalPages, $page] = $this->paginate($clientRepository, $request); 
    
        return $this->render('client/index.html.twig', [
            'datas' => $clients,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);

    }
    
    #[Route('/client/store', name: 'client.store', methods:['GET','POST'])]
    public function store(Request $request,EntityManagerInterface $entityManager ): Response
    {
        $client=new Client();
        $form=$this->createForm(ClientType::class,$client);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $client->setCreateAt(new \DateTimeImmutable());
            $client->setUpdateAt(new \DateTimeImmutable());

            $entityManager->persist($client);
            $entityManager->flush();
        }
        return $this->render('client/form.html.twig', [ 
            'formClient'=>$form->createView(),   
        ]);
    }

    
    #[Route('/client/create', name: 'client.create', methods:['GET', 'POST'])]
    public function create(Request $request): Response
    {
        // Créer un nouveau DTO
        $clientDto = new ClientDto();
        // Utiliser le DTO dans le formulaire
        $form = $this->createForm(ClientType::class, $clientDto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $surname = $clientDto->getSurname();
            $telephone = $clientDto->getTelephone();
            $adresse = $clientDto->getAdresse();
            $this->addFlash('success', 'Client ajouté : ' . $clientDto->getSurname());
            return $this->redirectToRoute('client.index');
        }
        return $this->render('client/form.html.twig', [
            'formClient' => $form->createView(),
        ]);
    }


    //path variable 
    //$_request : injonction de dependance
    #[Route('/client/show/{id?}', name: 'client.show', methods:['GET'])]
    public function show(int $id,ClientRepository $clientRepository, Request $request): Response
    {
        [$clients, $totalPages, $page] = $this->paginate($clientRepository, $request);
        return $this->render('client/index.html.twig', [
            'datas' => $clients,
            'currentPage' => $page,
            'totalPages' => $totalPages,        
        ]);
    }

    //query params
    #[Route('/client/search/telephone', name: 'client.searchClientByTelephone', methods:['GET'])]
    public function searchClientByTelephone(ClientRepository $clientRepository, Request $request): Response
    {
        $telephone = $request->query->get('tel');
        $client = $clientRepository->findOneBy(['telephone' => $telephone]);
        return $this->render('client/show.html.twig', [
            'client' => $client, 
        ]);
    }
    
    #[Route('/client/search/compte', name: 'client.searchClientByCompte', methods:['GET'])]
    public function searchClientByCompte(ClientRepository $clientRepository, Request $request): Response
    {
        $hasAccount = $request->query->get('hasAccount');

        if ($hasAccount === '1') {
            $clients = $clientRepository->findBy(['userr' => true]); 
        } elseif ($hasAccount === '0') {
            $clients = $clientRepository->findBy(['userr' => null]);
        } else {
            $clients = $clientRepository->findAll();
        }
        [$clients, $totalPages, $currentPage] = $this->paginateByFiltre($clients, $request);
        return $this->render('client/index.html.twig', [
            'datas' => $clients,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/client/remove/{id?}', name: 'client.remove', methods:['GET'])]
    public function remove(int $id,ClientRepository $clientRepository, Request $request): Response
    {
        $clients=$clientRepository->findAll();
        return $this->render('client/index.html.twig', [
            'datas' => $clients,     
        ]);
    }
    
    private function paginate(ClientRepository $clientRepository, Request $request, int $limit = 3): array
    {
        $page = $request->query->getInt('page', 1);
        $offset = ($page - 1) * $limit;
        $entities = $clientRepository->findBy([], null, $limit, $offset);
        $totalEntities = count($clientRepository->findAll());
        $totalPages = ceil($totalEntities / $limit);
    
        return [$entities, $totalPages, $page];
    }
    private function paginateByFiltre(array $clients, Request $request, int $limit = 3): array
    {
        $page = $request->query->getInt('page', 1);
        $offset = ($page - 1) * $limit;
        
        // S'assurer que nous paginons les clients filtrés
        $paginatedClients = array_slice($clients, $offset, $limit);
        $totalEntities = count($clients); // Utiliser le nombre total de clients filtrés
        $totalPages = ceil($totalEntities / $limit);

        return [$paginatedClients, $totalPages, $page];
    }

    }
