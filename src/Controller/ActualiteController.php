<?php

namespace App\Controller;

use App\Entity\Actu;
use App\Repository\ActuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualiteController extends AbstractController
{
    #[Route('/actualite', name: 'news')]
    public function index(ActuRepository $actuRepository): Response
    {
        $actualites = $actuRepository->findAll();

        return $this->render('actualite/nosActus.html.twig', [
            'controller_name' => 'ActualiteController',
            'actualites' => $actualites,
        ]);
    }

    #[Route('/actualite/{id<\d+>}', name: 'actu_description')]

    public function actu_description(Actu $actu): Response
    {
        return $this->render('actualite/actuCard.html.twig', [
            'actu' => $actu,
        ]);
    }
}
