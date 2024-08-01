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
            $newSession->setDateEnd($newSession->getDateStart());
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
        if ($session->getPlacesRestantes()>0) {        
            $intern = $internRepository->findOneBy(['id'=>$internId]);
            $session->addIntern($intern);
            $em->flush();
        }else {
            $this->addFlash('error','Il semble que la session n\'a plus de place');
        }
        return $this->redirectToRoute('session.show',['id'=>$session->getId()]);
    }

    #[Route('/session/delIntern-{id}-{internId}', name: 'session.delIntern',requirements : ['id'=>'\d+','internId'=>'\d+'])]
    public function delIntern(Session $session,int $internId , InternRepository $internRepository,EntityManagerInterface $em): Response
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

        //On modifie la date de fin selon la durée qu'on a ajouté
        $dateEnd=clone $session->getDateEnd();
        $session->setDateEnd(date_add($dateEnd,date_interval_create_from_date_string("$duration day")));
        //dd($session);
        $em->persist($session);
        $em->flush();
        // dd();
        return $this->redirectToRoute('session.show',['id'=>$session->getId()]);
    }

    #[Route('/session/delModule-{id}-{programId}', name: 'session.delModule',requirements : ['id'=>'\d+','programId'=>'\d+'])]
    public function delModule(Session $session,int $programId, ProgramRepository $programRepository , EntityManagerInterface $em): Response
    {   

        $program = $programRepository->findOneBy(['id'=>$programId]);
        $duration = $program->getDuration();
        $em->remove($program);
        $dateEnd=clone $session->getDateEnd();
        $session->setDateEnd(date_sub($dateEnd,date_interval_create_from_date_string("$duration day")));
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
