<?php

namespace App\Controller;

use App\Entity\EtatArticle;  
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EtatArticleController extends AbstractController
{
    #[Route('/etatArticle', name: 'app_etatArticle')]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $etatArticles = $entityManager->getRepository(EtatArticle::class)->findAll();
        
        return $this->render('etatArticle/index.html.twig', [
            'etatArticles' => $etatArticles,
        ]);
    }
}
