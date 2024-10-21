<?php

namespace App\Controller;

use App\Entity\Details;
use App\Entity\Dette;
use App\Entity\TypeDette;
use App\Enums\EtatDette;
use App\Enums\TypeDette as EnumsTypeDette;
use App\Form\ArticleSelectionType;
use App\Form\ClientDetteType;
use App\Form\DetteType;
use App\Form\SearchArticleType;
use App\Form\TypeDetteType;
use App\Repository\ArticleRepository;
use App\Repository\ClientRepository;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DetteController extends AbstractController
{
   
    #[Route('/dette', name: 'dette.index', methods: ['GET', 'POST'])]
    public function validateClient(Request $request, ClientRepository $clientRepository): Response
    {
        $formClientDette = $this->createForm(ClientDetteType::class); 
        $formClientDette->handleRequest($request);
    
        if ($formClientDette->isSubmitted() && $formClientDette->isValid()) {
            $data = $formClientDette->getData();
    
            // Recherche du client par prénom et téléphone
            $client = $clientRepository->findOneBy([
                'surname' => $data['surname'],
                'telephone' => $data['telephone'],
            ]);
    
            // Si le client est trouvé, on redirige vers la page form.html.twig avec l'ID du client
            if ($client) {
                return $this->redirectToRoute('dette.form', ['clientId' => $client->getId()]);
            } else {
                // Si le client n'existe pas, on affiche un message d'erreur
                $this->addFlash('error', 'Client non trouvé.');
            }
        }
        // Rendu du formulaire de validation
        return $this->render('dette/index.html.twig', [
            'formClientDette' => $formClientDette->createView(),
        ]);
    }

//-----------------------------------------------------------------------------------------------------^---
#[Route('/dette/form/{clientId}', name: 'dette.form')]
public function form($clientId, ClientRepository $clientRepository, ArticleRepository $articleRepository): Response
{
    // Récupérer le client à partir de l'ID
    $client = $clientRepository->find($clientId);
    if (!$client) {
        throw $this->createNotFoundException('Client non trouvé');
    }

    // Récupérer la liste des articles
    $articles = $articleRepository->findAll();

    // Afficher le formulaire
    return $this->render('dette/form.html.twig', [
        'client' => $client,
        'articles' => $articles,
    ]);
}

#[Route('/dette/save/{clientId}', name: 'dette.save', methods: ['POST'])]
public function save($clientId, Request $request, ClientRepository $clientRepository, ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
{
    // Récupérer le client à partir de l'ID
    $client = $clientRepository->find($clientId);
    if (!$client) {
        throw $this->createNotFoundException('Client non trouvé');
    }

    // Créer une nouvelle dette
    $dette = new Dette();
    $dette->setClient($client);
    $dette->setMontantVerse(0);
    $dette->setMontantRestant(0);
    $dette->setEtat(EtatDette::enCours);
    $dette->setType(EnumsTypeDette::nonSolde);
    $dette->setCreateAt(new \DateTimeImmutable());
    $dette->setUpdateAt(new \DateTimeImmutable());

    // Récupérer les articles cochés depuis le formulaire
    $selectedArticlesJson = $request->request->get('selectedArticles');
    $selectedArticles = json_decode($selectedArticlesJson, true);

    // Pour chaque article sélectionné, créer un objet Details
    foreach ($selectedArticles as $articleData) {
        $article = $articleRepository->find($articleData['id']); // trouve l'article par ID
        if ($article) {
            $details = new Details(); // Créer un nouveau détail
            $details->setArticle($article); // Associer l'article
            $details->setDette($dette); // Associer la dette
            $details->setQteDette($articleData['quantite']); // Associer la quantité
            $entityManager->persist($details); // Persister le détail dans la base
        }
    }

    $montantTotal=0;
    foreach ($selectedArticles as $articleData) {
        $montantTotal += $articleData['prix'] * $articleData['quantite']; // Ajouter au montant total
    }

    $dette->setMontant($montantTotal); 

    // Enregistrer la Dette

    $entityManager->persist($dette);
    $entityManager->flush();

    $this->addFlash('success', 'Dette enregistrée avec succès.');
    return $this->redirectToRoute('dette.index');
}


//----------------------------------------------------------------------------------------------------------

    #[Route('/dette/liste', name: 'dette.listerLesDettes')]
    public function liste(DetteRepository $detteRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1); 
        $limit = 3;
        $etats = $request->query->get('etat'); 
        if (empty($etats)) {
            $dettes = $detteRepository->paginateDettes($page, $limit);
        } else {
        }
      
          $count = count($dettes);
        $totalPages = ceil($count / $limit);

        return $this->render('dette/listeDette.html.twig', [
            'dettes' => $dettes,
            'etats'=>$etats,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
    }   
    

    #[Route('/dette/get/{id}', name: 'dette.getDetteById', methods:['GET','POST'])]
    public function getDetteByClient(ClientRepository $clientRepository ,DetteRepository $detteRepository, int $id): Response
    {
        $dettes = $detteRepository->findOneBy(['id' => $id]);
        if (!$dettes) {
            throw $this->createNotFoundException('dette non trouvé');
        }
        return $this->render('dette/show.html.twig', [
            'datas' => $dettes,          
        ]);
    }

    
}