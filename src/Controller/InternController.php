<?php

namespace App\Controller;

use App\Entity\Intern;
use App\Form\InternType;
use App\Repository\InternRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InternController extends AbstractController
{
    #[Route('/intern', name: 'app_intern')]
    public function index(InternRepository $internRepository): Response
    {
        $interns = $internRepository->findBy([],['name'=>'ASC']);
        return $this->render('intern/index.html.twig', [
            'controller_name' => 'InternController',
            'interns' => $interns,
        ]);
    }

    #[Route('/intern/new', name: 'intern.new')]
    #[Route('/intern/edit-{id}', name: 'intern.edit',requirements : ['id'=>'\d+'])]
    public function new(Intern $intern = null,Request $request,EntityManagerInterface $em): Response
    {
        if (!$intern) {
            $intern = new Intern();
        }

        $form = $this->createForm(InternType::class , $intern);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid() ) {
            $newIntern= $form->getData();
            $em->persist($newIntern);
            $em->flush();
            $this->addFlash('success','Vous avez bien ajouté un nouveau stagiaire !');
            return $this->redirectToRoute('app_intern');
        }

        return $this->render('intern/new.html.twig', [
            'controller_name' => 'InternController',
            'form'=>$form,
        ]);
    }

    #[Route('/intern/show-{id}', name: 'intern.show',requirements : ['id'=>'\d+'])]
    public function show(Intern $intern): Response
    {

        return $this->render('intern/show.html.twig', [
            'controller_name' => 'InternController',
            'intern'=>$intern,
        ]);
    }

    #[Route('/intern/delete-{id}', name: 'intern.delete',requirements : ['id'=>'\d+'])]
    public function delete(Intern $intern,EntityManagerInterface $em): Response
    {
        $internMessage =(string) $intern;
        $em->remove($intern);
        $em->flush();
        $this->addFlash('success',"Vous avez bien supprimer $internMessage !");
        return $this->redirectToRoute('app_intern');
    }
}
