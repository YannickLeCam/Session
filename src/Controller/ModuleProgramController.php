<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModuleProgramController extends AbstractController
{
    #[Route('/module/program', name: 'app_module_program')]
    public function index(): Response
    {
        return $this->render('module_program/index.html.twig', [
            'controller_name' => 'ModuleProgramController',
        ]);
    }
}
