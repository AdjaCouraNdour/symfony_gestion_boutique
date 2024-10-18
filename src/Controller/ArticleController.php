<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\SearchArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'article.index',methods:['GET','POST'])]
    public function index(ArticleRepository $articleRepository,Request $request): Response
    {
        
        $formSearch = $this->createForm(SearchArticleType::class);
        $formSearch->handleRequest($request);
        $page=$request->query->getInt('page',1);
        $count=0;
        $totalPages=0;
        $limit=3;
        $libelle = null;

        if ($formSearch->isSubmitted($request) && $formSearch->isValid()){
            $libelle = $formSearch->get('libelle')->getData();
        }
            // $articles = $articleRepository->findBy(['libelle' => $formSearch->get('libelle')->getData()]);
        // }else{
            $articles = $articleRepository->paginateArticle($page, $limit, $libelle);
            $count=$articles->count();
            $totalPages=ceil($count / $limit);
        // }

        return $this->render('article/index.html.twig', [
            'datas' => $articles,
            'formSearch'=>$formSearch->createView(),
            'page'=>$page,
            'totalPages'=>$totalPages,
            'libelle'=>$libelle, 
        ]);
    }


    #[Route('/article/store', name: 'article.store', methods:['GET','POST'])]
    public function store(Request $request,EntityManagerInterface $entityManager ): Response
    {
        $article=new Article();
        $form=$this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->getReference();
            $article->getLibelle();
            $article->getQteStock();
            $article->getPrix();
            $article->getCreateAt(new \DateTimeImmutable());
            $article->getUpdateAt(new \DateTimeImmutable());

            $entityManager->persist($article);
            $entityManager->flush();
        }
        return $this->render('article/form.html.twig', [ 
            'formArticle'=>$form->createView(),   
        ]);
    }

    #[Route('/article/show/{id}', name: 'article.showArticleById', methods:['GET','POST'])]
    public function showarticleById(ArticleRepository $articleRepository, int $id): Response
    {
        $articles = $articleRepository->findOneBy(['id' => $id]);
        if (!$articles) {
            throw $this->createNotFoundException('article non trouvé');
        }
        return $this->render('article/show.html.twig', [
            'datas' => $articles,          
        ]);
    }
}
