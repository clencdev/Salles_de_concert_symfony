<?php

namespace App\Controller\Admin;

use App\Repository\EventRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

use App\Entity\Actu;
use App\Entity\Event;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($this->adminUrlGenerator->setController(ActuCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }
    #[Route('/admin/calendar', name: 'calendar')]
    public function calendar(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();
        $formattedEvents = [];

        foreach ($events as $event) {
            $formattedEvents[] = [
                'title' => $event->getEventName(),
                'start' => $event->getEventDate()->format('Y-m-d'),
            ];
        }
    
        return $this->render('admin/calendar.html.twig', [
            'events' => json_encode($formattedEvents),
        ]);
}

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Concert Symf');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home'); 
        yield MenuItem::linkToCrud('Actu', 'fas fa-list', Actu::class);
        yield MenuItem::linkToCrud('Event', 'fas fa-list', Event::class);
        yield MenuItem::linkToRoute('Calendrier', 'fa fa-calendar', 'calendar');
        
    }
}