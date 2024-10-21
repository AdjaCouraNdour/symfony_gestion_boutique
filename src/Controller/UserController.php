<?php

namespace App\Controller;

use App\Dto\UserSearchDto;
use App\Entity\User;
use App\Form\SearchUserType;
use App\Form\UserType;
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
        $userSearchDto=new UserSearchDto();
        $formSearch = $this->createForm(SearchUserType::class ,$userSearchDto);
        $formSearch->handleRequest($request);
        $page=$request->query->getInt('page',1);$count=0;$totalPages=0;$limit=3;
        $telephone = null;
        
        $hasAccount = $request->query->get('hasAccount');
        if ($hasAccount === '1') {
            $users = $userRepository->findBy(['userr' => true]); 

        } elseif ($hasAccount === '0') {
            $users = $userRepository->findBy(['userr' => null]);

        } elseif ($formSearch->isSubmitted($request) && $formSearch->isValid()){
            // $users = $userRepository->findBy([
            //     'telephone'=>$userSearchDto->telephone,
            //     'surname'=>$userSearchDto->surname
            // ]) ;
            $users = $userRepository->findUserBy($userSearchDto,$page,$limit) ;

        }else{
            $users= $userRepository->paginateUser($page,$limit);    
        }
        $count=$users->count();
        $totalPages=ceil($count / $limit);

        return $this->render('user/index.html.twig', [
            'telephone'=>$telephone,
            'datas' => $users,
            'formSearch'=>$formSearch->createView(),
            'page'=>$page,
            'totalPages'=>$totalPages, 
        ]);
    }

    #[Route('/user/store', name: 'user.store', methods:['GET','POST'])]
    public function store(Request $request,EntityManagerInterface $entityManager ): Response
    {
        $user=new User();
        $form=$this->createForm(UserType::class,$user);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        
            $user->getCreateAt(new \DateTimeImmutable());
            $user->getUpdateAt(new \DateTimeImmutable());
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('user.index');

        }

        return $this->render('user/form.html.twig', [ 
            'formUser'=>$form->createView(),   
        ]);
    }
}