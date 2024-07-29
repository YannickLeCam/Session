<?php

namespace App\Controller;

use App\Repository\ModuleProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
