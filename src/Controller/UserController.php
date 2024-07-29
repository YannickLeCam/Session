<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index( UserRepository $userRepository): Response
    {

        $users = $userRepository->findBy([],['name'=>'ASC']);
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/new', name: 'user.new')]
    public function new(Request $request,EntityManagerInterface $em): Response
    {
        $user = new User();


        $form = $this->createForm(UserType::class , $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid() ) {
            $newUser= $form->getData();
            $newUser->setRoles(['ROLE_USER']);
            $newUser->setPassword(password_hash($newUser->getPassword(),PASSWORD_DEFAULT));
            $em->persist($newUser);
            $em->flush();
            $this->addFlash('success','Vous avez bien ajouté une nouvelle catégorie !');
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/new.html.twig', [
            'form'=>$form,
        ]);
    }
}
