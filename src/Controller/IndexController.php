<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventRepository; 


class IndexController extends AbstractController
{
    public function __construct(
        private EventRepository $eventrepository,
        private ActuRepository $actuRepository
    )
    {

    }
    #[Route('/index', name: 'home')]
    public function index(): Response
    {

        $events = $this->eventrepository->findAll();
        $actus = $this->actuRepository->findAll();
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'events' => $events,
            'actus' => $actus,
        ]);
    }
}
