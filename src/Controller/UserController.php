<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index( UserRepository $userRepository): Response
    {

        $users = $userRepository->findBy([],['name'=>'ASC']);
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
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
            $this->addFlash('success','Vous avez bien ajouté une nouvel utilisateur !');
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/new.html.twig', [
            'controller_name' => 'UserController',
            'form'=>$form,
        ]);
    }

    #[Route('user/show-{id}', name: 'user.show',requirements : ['id'=>'\d+'])]
    public function show(User $user,SessionRepository $sessionRepository): Response
    {
        $oldSessions = $sessionRepository->findSessionPassed($user->getId());
        $futurSessions = $sessionRepository->findSessionInComing($user->getId());
        $currentSessions =$sessionRepository->findSessionCurrent($user->getId());
        return $this->render('user/show.html.twig', [
            'controller_name' => 'UserController',
            'user'=>$user,
            'oldSessions'=>$oldSessions,
            'currentSessions' => $currentSessions,
            'futurSessions' => $futurSessions,
        ]);
    }

    #[Route('/user/delete-{id}', name: 'user.delete',requirements : ['id'=>'\d+'])]
    public function delete(User $user,EntityManagerInterface $em): Response
    {
        $userMessage =(string) $user;
        $em->remove($user);
        $em->flush();
        $this->addFlash('success',"Vous avez bien supprimer $userMessage !");
        return $this->redirectToRoute('app_user');
    }

    #[Route('/user/getCurrentSession-{id}-{type}', name: 'user.currentAjax', requirements: ['id' => '\d+', 'type' => 'current|future|past|'])]
    #[IsGranted('ROLE_USER')]
    public function getCurrentSessionAjax(User $user,string $type, SessionRepository $sessionRepository, SerializerInterface $serializer ): JsonResponse
    {
        if ($this->getUser()->getId()=== $user->getId()) {
            
            switch ($type) {
                case 'current':
                    $sessions = $sessionRepository->findSessionCurrent($user->getId());
                    break;
                case 'future':
                    $sessions = $sessionRepository->findSessionInComing($user->getId());
                    break;
                case 'past':
                    $sessions = $sessionRepository->findSessionPassed($user->getId());
                    break;
                default:
                    return new JsonResponse(['status' => 'error', 'message' => 'Type de session non valide'], 400);
            }

            if (!$sessions) {
                return new JsonResponse(['status' => 'error', 'message' => 'Session non trouvée'], 404);
            }
            $data = array_map(function ($session) {
                return [
                    'id' => $session->getId(),
                    'name' => $session->getName(),
                    'dateStart' => $session->getFormattedDateStart(),
                    'dateEnd' => $session->getFormattedDateEnd(),
                ];
            }, $sessions);
    
            return new JsonResponse($data);
        }else {
            return new JsonResponse(['status' => 'error', 'message' => 'Utilisateur invalide . . .'], 404);
        }


    }
}
