<?php

namespace App\Controller;

use App\Entity\Dette;
use App\Entity\TypeDette;
use App\Form\DetteType;
use App\Form\SearchArticleType;
use App\Form\TypeDetteType;
use App\Repository\ArticleRepository;
use App\Repository\DetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DetteController extends AbstractController
{

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
    
    #[Route('/dette', name: 'dette.index',methods:['GET','POST'])]
    public function index(ArticleRepository $articleRepository,Request $request): Response
    {     
        $formSearch = $this->createForm(SearchArticleType::class);
        $formSearch->handleRequest($request);
        $page=$request->query->getInt('page',1);
        $count=0;
        $totalPages=0;
        $limit=3;
      
        if ($formSearch->isSubmitted($request) && $formSearch->isValid()){
            $articles = $articleRepository->findBy(['libelle' => $formSearch->get('libelle')->getData()]);
        }else{
           $articles= $articleRepository->paginateArticle($page,$limit);
            $count=$articles->count();
            $totalPages=ceil($count / $limit);
        }

        return $this->render('dette/index.html.twig', [
            'datas' => $articles,
            'formSearch'=>$formSearch->createView(),
            'page'=>$page,
            'totalPages'=>$totalPages, 
        ]);
    }


    #[Route('/dette/store', name: 'dette.store')]
    public function store(EntityManagerInterface $entityManager, Request $request): Response
    {
        $dette = new Dette();
        $form = $this->createForm(DetteType::class, $dette);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            if ($dette->getMontantVerse() >= $dette->getMontant()) {
                $dette->setType(TypeDette::solde); 
            } else {
                $dette->setType(TypeDette::nonSolde);
            }
            $dette->getClient();
            $dette->getDetails();
            $entityManager->persist($dette);
            $entityManager->flush();
            return $this->redirectToRoute('dette_index');
        }
        return $this->render('dette/creer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
}