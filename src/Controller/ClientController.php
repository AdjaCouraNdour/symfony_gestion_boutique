<?php

// src/Controller/ClientController.php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\User;
use App\Repository\ClientRepository; 
use App\Form\ClientType;
use App\Form\SearchClientType;
use App\Form\UserType;
use App\Repository\ArticleRepository;
use App\Repository\DetailsRepository;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
  
    #[Route('/client', name: 'client.index', methods:['GET','POST'])]
    public function index(ClientRepository $clientRepository, Request $request): Response 
    {
        $formSearch = $this->createForm(SearchClientType::class);
        $formSearch->handleRequest($request);
        $page=$request->query->getInt('page',1);
        $count=0;
        $totalPages=0;
        $limit=3;
        $telephone = null;

        if ($formSearch->isSubmitted($request) && $formSearch->isValid()){
            $telephone = $formSearch->get('telephone')->getData();  
            // $clients = $clientRepository->findBy(['telephone' => $formSearch->get('telephone')->getData()]);
        }
        // else{
           $clients= $clientRepository->paginateClient($page,$limit,$telephone);
            $count=$clients->count();
            $totalPages=ceil($count / $limit);
        // }

        return $this->render('client/index.html.twig', [
            'telephone'=>$telephone,
            'datas' => $clients,
            'formSearch'=>$formSearch->createView(),
            'page'=>$page,
            'totalPages'=>$totalPages, 
        ]);

    }
    
    #[Route('/client/store', name: 'client.store', methods:['GET','POST'])]
public function store(Request $request, EntityManagerInterface $entityManager): Response
{
    $client = new Client();
    $user = new User(); 

    $formClient = $this->createForm(ClientType::class, $client);
    $formUser = $this->createForm(UserType::class, $user);

    $formClient->handleRequest($request);
    $formUser->handleRequest($request);

    if ($formClient->isSubmitted() && $formClient->isValid()) {

        $client->setBlocked(false);
        $client->setCreateAt(new \DateTimeImmutable());
        $client->setUpdateAt(new \DateTimeImmutable());

        $addUser = $formClient->get('addUser')->getData(); 

        if ($addUser && $formUser->isSubmitted() && $formUser->isValid()) {
            $user->setBlocked(false);
            $user->setCreateAt(new \DateTimeImmutable());
            $user->setUpdateAt(new \DateTimeImmutable());

            $user->setClient($client);
            $client->setUserr($user);

            $entityManager->persist($user);
        }

        $entityManager->persist($client);
        $entityManager->flush();

        return $this->redirectToRoute('client.index');
    }

    return $this->render('client/form.html.twig', [
        'formClient' => $formClient->createView(),
        'formUser' => $formUser->createView(),
    ]);
}


    #[Route('/client/show/{id}', name: 'client.showClientById', methods:['GET','POST'])]
    public function showClientById(ClientRepository $clientRepository, int $id): Response
    {
        $clients = $clientRepository->findOneBy(['id' => $id]);
        if (!$clients) {
            throw $this->createNotFoundException('Client non trouvé');
        }
        return $this->render('client/show.html.twig', [
            'datas' => $clients,          
        ]);
    }


    #[Route('/client/{id}/dettes', name: 'client.showClientDettesById', methods: ['GET'])]
    public function showClientDettesById(ClientRepository $clientRepository,ArticleRepository $articleRepository, DetteRepository $detteRepository, DetailsRepository $detailsRepository,Request $request, int $id): Response
    {
        $client = $clientRepository->find($id);
        $dettes = $detteRepository->findBy(['client' => $id]);

        if (!$client ) {
            throw $this->createNotFoundException('Client non  trouvés.');
        }
        if (empty($dettes)) {
            return $this->render('client/erreurs.html.twig', [
                'client' => $client,
            ]);
        }

        $articles = [];
        foreach ($dettes as $dette) {
            $details = $detailsRepository->findBy(['dette' => $dette->getId()]);
            foreach ($details as $detail) {
                $article = $detail->getArticle();
                if ($article) { 
                    $articles[] = [
                        'libelle' => $article->getLibelle(),
                        'quantite' => $detail->getQteDette(),
                        'prix_unitaire' => $article->getPrix(),
                        'prix_total' => $detail->getQteDette() * $article->getPrix(),
                    ];
                }
            }
        }
        return $this->render('client/dette.html.twig', [
            'client' => $client,
            'dettes' => $dettes,
            'details' => $details,
            'articles' => $articles,
        ]);
    }
    
    //path variable 
    //$_request : injonction de dependance
    // #[Route('/client/show/{id?}', name: 'client.show', methods:['GET'])]
    // public function show(int $id,ClientRepository $clientRepository, Request $request): Response
    // {
    //     return $this->render('client/show.html.twig', [
    //         'datas' => $clients,        
    //     ]);
    // }


    // #[Route('/client/create', name: 'client.create', methods:['GET', 'POST'])]
    // public function create(Request $request): Response
    // {
    //     // Créer un nouveau DTO
    //     $clientDto = new ClientDto();
    //     // Utiliser le DTO dans le formulaire
    //     $form = $this->createForm(ClientType::class, $clientDto);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $surname = $clientDto->getSurname();
    //         $telephone = $clientDto->getTelephone();
    //         $adresse = $clientDto->getAdresse();
    //         $this->addFlash('success', 'Client ajouté : ' . $clientDto->getSurname());
    //         return $this->redirectToRoute('client.index');
    //     }
    //     return $this->render('client/form.html.twig', [
    //         'formClient' => $form->createView(),
    //     ]);
    // }


    //query params
    // #[Route('/client/search/telephone', name: 'client.searchClientByTelephone', methods:['GET'])]
    // public function searchClientByTelephone(ClientRepository $clientRepository, Request $request): Response
    // {
    //     $telephone = $request->query->get('tel');
    //     $client = $clientRepository->findOneBy(['telephone' => $telephone]);
    //     return $this->render('client/show.html.twig', [
    //         'client' => $client, 
    //     ]);
    // }
    
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
