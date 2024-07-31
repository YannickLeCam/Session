<?php

namespace App\Controller;

use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgramController extends AbstractController
{
    #[Route('/program', name: 'app_program')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();
        return $this->render('program/index.html.twig', [
            'controller_name' => 'ProgramController',
            'programs' => $programs,
        ]);
    }

    #[Route('/program/new', name: 'program.new')]
    #[Route('/program/edit-{id}', name: 'program.edit',requirements : ['id'=>'\d+'])]
    public function new(Program $program = null,Request $request,EntityManagerInterface $em): Response
    {
        if (!$program) {
            $program = new Program();
        }

        $form = $this->createForm(ProgramType::class , $program);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {
            $newProgram= $form->getData();
            $em->persist($newProgram);
            $em->flush();
            $this->addFlash('success','Vous avez bien ajouté un nouveau program !');
            return $this->redirectToRoute('app_program');
        }

        return $this->render('program/new.html.twig', [
            'controller_name' => 'ProgramController',
            'form'=>$form,
        ]);
    }

    #[Route('program/show-{id}', name: 'program.show',requirements : ['id'=>'\d+'])]
    public function show(Program $program): Response
    {
        return $this->render('program/show.html.twig', [
            'controller_name' => 'ProgramController',
            'Program'=>$program,
        ]);
    }

    #[Route('/program/delete-{id}', name: 'program.delete',requirements : ['id'=>'\d+'])]
    public function delete(Program $program,EntityManagerInterface $em): Response
    {
        $programMessage =(string) $program;
        $em->remove($program);
        $em->flush();
        $this->addFlash('success',"Vous avez bien supprimer $programMessage !");
        return $this->redirectToRoute('app_program');
    }
}
