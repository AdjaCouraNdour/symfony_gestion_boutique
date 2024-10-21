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
    
            $client = $clientRepository->findOneBy([
                'surname' => $data['surname'],
                'telephone' => $data['telephone'],
            ]);
    
            if ($client) {
                return $this->redirectToRoute('dette.form', ['clientId' => $client->getId()]);
            } else {
                $this->addFlash('error', 'Client non trouvé.');
            }
        }
        return $this->render('dette/index.html.twig', [
            'formClientDette' => $formClientDette->createView(),
        ]);
    }

//-----------------------------------------------------------------------------------------------------^---
#[Route('/dette/form/{clientId}', name: 'dette.form')]
public function form($clientId, ClientRepository $clientRepository, ArticleRepository $articleRepository): Response
{
    $client = $clientRepository->find($clientId);
    if (!$client) {
        throw $this->createNotFoundException('Client non trouvé');
    }

    $articles = $articleRepository->findAll();

    return $this->render('dette/form.html.twig', [
        'client' => $client,
        'articles' => $articles,
    ]);
}

#[Route('/dette/save/{clientId}', name: 'dette.save', methods: ['POST'])]
public function save($clientId, Request $request, ClientRepository $clientRepository, ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
{
    $client = $clientRepository->find($clientId);
    if (!$client) {
        throw $this->createNotFoundException('Client non trouvé');
    }

    $dette = new Dette();
    $dette->setClient($client);
    $dette->setMontantVerse(0);
    $dette->setMontantRestant(0);
    $dette->setEtat(EtatDette::enCours);
    $dette->setType(EnumsTypeDette::nonSolde);
    $dette->setCreateAt(new \DateTimeImmutable());
    $dette->setUpdateAt(new \DateTimeImmutable());

    $selectedArticlesJson = $request->request->get('selectedArticles');
    $selectedArticles = json_decode($selectedArticlesJson, true);

    foreach ($selectedArticles as $articleData) {
        $article = $articleRepository->find($articleData['id']); 
        if ($article) {
            $details = new Details(); 
            $details->setArticle($article);
            $details->setDette($dette); 
            $details->setQteDette($articleData['quantite']); 
            $entityManager->persist($details); 
        }
    }

    $montantTotal=0;
    foreach ($selectedArticles as $articleData) {
        $montantTotal += $articleData['prix'] * $articleData['quantite']; 
    }

    $dette->setMontant($montantTotal); 

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