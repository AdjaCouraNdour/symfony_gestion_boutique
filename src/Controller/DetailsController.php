<?php

namespace App\Controller;

use App\Entity\Details;  
use App\Form\DetailsType;
use App\Repository\DetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DetailsController extends AbstractController
{
    // #[Route('/details', name: 'details.index')]
    // public function index(DetailsRepository $detailsRepository): Response
    // {
    //     $details = $detailsRepository->findAll();
        
    //     return $this->render('details/index.html.twig', [
    //         'datas' => $details,
    //     ]);
    // }
}