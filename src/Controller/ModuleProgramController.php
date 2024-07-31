<?php

namespace App\Controller;

use App\Entity\ModuleProgram;
use App\Form\ModuleProgramType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ModuleProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleProgramController extends AbstractController
{
    #[Route('/module', name: 'app_module_program')]
    public function index(ModuleProgramRepository $moduleProgramRepository): Response
    {

        $modules = $moduleProgramRepository->findBy([],['name'=>'ASC']);
        return $this->render('module_program/index.html.twig', [
            'controller_name' => 'ModuleProgramController',
            'modules'=>$modules,
        ]);


    }

    #[Route('/module/new', name: 'module_program.new')]
    #[Route('/module/edit-{id}', name: 'module_program.edit',requirements : ['id'=>'\d+'])]
    public function new(ModuleProgram $moduleProgram = null,Request $request,EntityManagerInterface $em): Response
    {
        if (!$moduleProgram) {
            $moduleProgram = new ModuleProgram();
        }

        $form = $this->createForm(ModuleProgramType::class , $moduleProgram);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() ) {

            $newModuleProgram= $form->getData();
            dump($newModuleProgram);
            $em->persist($newModuleProgram);
            $em->flush();
            $this->addFlash('success','Vous avez bien ajouté un nouveau module !');
            return $this->redirectToRoute('app_module_program');
        }

        return $this->render('module_program/new.html.twig', [
            'controller_name' => 'CategoryController',
            'form'=>$form,
        ]);
    }

    #[Route('/module/show-{id}', name: 'module_program.show',requirements : ['id'=>'\d+'])]
    public function show(ModuleProgram $moduleProgram): Response
    {
        return $this->render('module_program/show.html.twig', [
            'controller_name' => 'ModuleProgramController',
            'module'=>$moduleProgram,
        ]);


    }

    #[Route('/module/delete-{id}', name: 'module_program.delete',requirements : ['id'=>'\d+'])]
    public function delete(ModuleProgram $moduleProgram,EntityManagerInterface $em): Response
    {
        $moduleMessage =(string) $moduleProgram;
        $em->remove($moduleProgram);
        $em->flush();
        $this->addFlash('success',"Vous avez bien supprimer $moduleMessage !");
        return $this->redirectToRoute('app_module_program');
    }
}
