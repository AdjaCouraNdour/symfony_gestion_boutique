<?php

namespace App\Controller;

use App\Entity\EtatArticle;
use App\Repository\EtatArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EtatArticleController extends AbstractController
{
    #[Route('/etatArticle', name: 'etatArticle.index')]
    public function index(EtatArticleRepository $etatArticleRepository): Response
    {
        $etatArticles = $etatArticleRepository->findAll();
        
        return $this->render('etatArticle/index.html.twig', [
            'datas' => $etatArticles,
        ]);
    }
}
