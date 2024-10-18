<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user.index', methods:['GET','POST'])]
    public function index(UserRepository $userRepository, Request $request): Response 
    {
        $formSearch = $this->createForm(SearchUserType::class);
        $formSearch->handleRequest($request);
        $page=$request->query->getInt('page',1);
        $count=0;
        $totalPages=0;
        $limit=3;

        if ($formSearch->isSubmitted($request) && $formSearch->isValid()){
            $users = $userRepository->findBy(['login' => $formSearch->get('login')->getData()]);
        }else{
           $users= $userRepository->paginateUser($page,$limit);
            $count=$users->count();
            $totalPages=ceil($count / $limit);
        }

        return $this->render('user/index.html.twig', [
            'datas' => $users,
            'formSearch'=>$formSearch->createView(),
            'page'=>$page,
            'totalPages'=>$totalPages, 
        ]);

    }
}