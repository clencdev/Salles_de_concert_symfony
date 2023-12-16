<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementsController extends AbstractController
{
    
    #[Route('/evenements', name: 'evenements')]
    public function index(EventRepository $eventRepository): Response
    {


        $evenements = $eventRepository->findall();
       
        return $this->render('evenements/nosEvents.html.twig', [
            'controller_name' => 'EvenementsController',
            'evenements' => $evenements,
        ]);
    }

    #[Route('/evenements/{id<\d+>}', name: 'evenement_description')]

    public function event_description(Event $event): Response
    {
        return $this->render('evenemments/eventCard.html.twig', [
            'event' => $event,
        ]);
    }
}
