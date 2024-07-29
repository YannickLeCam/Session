<?php

namespace App\Controller;

use App\Repository\InternRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}
