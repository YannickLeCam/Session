<?php

namespace App\Controller;

use App\Entity\Intern;
use App\Entity\Program;
use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\InternRepository;
use App\Repository\ModuleProgramRepository;
use App\Repository\ProgramRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {   
        $sessions = $sessionRepository->findBy([],['dateStart'=>'ASC']);
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
            'sessions'=>$sessions,
        ]);
    }

    #[Route('/session/new', name: 'session.new')]
    #[Route('/session/edit-{id}', name: 'session.edit',requirements : ['id'=>'\d+'])]
    public function new(Session $session = null,Request $request,EntityManagerInterface $em): Response
    {
        if (!$session) {
            $session = new Session();
        }

        $form = $this->createForm(SessionType::class , $session);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $newSession= $form->getData();
            $em->persist($newSession);
            $em->flush();
            $this->addFlash('success','Vous avez bien ajouté une nouvelle session !');
            return $this->redirectToRoute('app_session');
        }

        return $this->render('session/new.html.twig', [
            'controller_name' => 'CategoryController',
            'form'=>$form,
        ]);
    }

    #[Route('/session/show-{id}', name: 'session.show',requirements : ['id'=>'\d+'])]
    public function show(Session $session,SessionRepository $sessionRepository): Response
    {   
        $internsNotIn = $sessionRepository->findInternsNotIn($session->getId());
        $modulesNotIn = $sessionRepository->findModulesProgramsNotIn($session->getId());
        return $this->render('session/show.html.twig', [
            'controller_name' => 'SessionController',
            'session'=>$session,
            'internsNotIn' => $internsNotIn,
            'modulesNotIn' => $modulesNotIn,
        ]);
    }

    #[Route('/session/addIntern-{id}-{internId}', name: 'session.addIntern',requirements : ['id'=>'\d+','internId'=>'\d+'])]
    public function addIntern(Session $session,int $internId , InternRepository $internRepository, EntityManagerInterface $em): Response
    {   
        $intern = $internRepository->findOneBy(['id'=>$internId]);
        $session->addIntern($intern);
        $em->flush();
        return $this->redirectToRoute('session.show',['id'=>$session->getId()]);
    }

    #[Route('/session/delIntern-{id}-{internId}', name: 'session.delIntern',requirements : ['id'=>'\d+','internId'=>'\d+'])]
    public function delIntern(Session $session,int $internId , int $duration , InternRepository $internRepository,EntityManagerInterface $em): Response
    {   
        $intern = $internRepository->findOneBy(['id'=>$internId]);
        $session->removeIntern($intern);
        $em->flush();
        return $this->redirectToRoute('session.show',['id'=>$session->getId()]);
    }

    #[Route('/session/addModule-{id}-{moduleId}-{duration}', name: 'session.addModule',requirements : ['id'=>'\d+','moduleId'=>'\d+','duration'=>'\d+'])]
    public function addModule(Session $session,int $moduleId , int $duration , ModuleProgramRepository $moduleRepository, EntityManagerInterface $em): Response
    {   
        $module = $moduleRepository->findOneBy(['id'=>$moduleId]);
        $program= new Program();
        $program->setSession($session);
        $program->setDuration($duration);
        $program->setModule($module);
        $em->persist($program);
        $em->flush();
        return $this->redirectToRoute('session.show',['id'=>$session->getId()]);
    }

    #[Route('/session/delModule-{id}-{programId}', name: 'session.delModule',requirements : ['id'=>'\d+','programId'=>'\d+'])]
    public function delModule(Session $session,int $programId, ProgramRepository $programRepository , EntityManagerInterface $em): Response
    {   
        $program = $programRepository->findOneBy(['id'=>$programId]);
        $session->removeProgram($program);
        $em->flush();
        return $this->redirectToRoute('session.show',['id'=>$session->getId()]);
    }

    #[Route('/session/delete-{id}', name: 'session.delete',requirements : ['id'=>'\d+'])]
    public function delete(Session $session,EntityManagerInterface $em): Response
    {
        $sessionMessage =(string) $session;
        $em->remove($session);
        $em->flush();
        $this->addFlash('success',"Vous avez bien supprimer $sessionMessage !");
        return $this->redirectToRoute('app_session');
    }
}
