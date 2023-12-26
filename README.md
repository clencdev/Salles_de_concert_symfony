# Projet de Salle de Concert avec Symfony

Ce projet est une réplique de mon projet PHP antérieur. L'objectif était d'explorer les différentes fonctionnalités de Symfony. J'ai aussi intégré une API de calendrier avec JavaScript et utilisé Bootstrap pour la gestion du CSS.

## Début du Projet : Base de Données

J'ai débuté par la création de mes entités et des CRUDs pour les entités Event, qui stockent les données des prochains concerts, et Actu pour la partie blog. J'ai généré une entité User avec la commande php bin/console make:user, fournissant des interfaces pour la gestion des utilisateurs. Pour restreindre l'accès au CRUD aux administrateurs, j'ai utilisé EasyAdmin (composer require easycorp/easyadmin-bundle) et créé un tableau de bord avec ```php bin/console make:admin:dashboard```. Voici la propriété Roles dans mon entité User :



```#[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */```
      Dans services.yaml, j'ai défini l'accès aux parties admin des CRUDs uniquement pour les administrateurs : 
       ```access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        # - { path: ^/profile, roles: ROLE_USER }
```;



J'ai créé un utilisateur administrateur avec les fixtures (composer require --dev orm-fixtures) et Faker (composer require --dev fakerphp/faker). Le mot de passe est haché via un EventSubscriber lors de l'événement prePersist :


```      class Hashpassword implements EventSubscriberInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public function getSubscribedEvents(): array
    {
        return  [
            Events::prePersist,
        ];
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof User){
            return;
        }

        $entity->setPassword($this->hasher->hashPassword($entity, $entity->getPassword()));
    }
} ```
Avec ```php bin/console make:admin:crud```, j'ai créé les CRUDs pour Actu et Event.

## Configuration des Contrôleurs et Tableau de Bord

J'ai configuré mes contrôleurs pour créer des formulaires pour Actu et Event, et adapté mon tableau de bord pour afficher directement la section Actu.

## Sécurité et Authentification

J'ai implémenté une authentification avec ```php bin/console make:auth```, permettant la connexion et la déconnexion. Seul l'administrateur a accès à la partie admin CRUD.

## Partie Front : Templates et Fonctionnalités

J'ai utilisé mes templates de base, incluant une barre de navigation et un footer. Pour chaque actu et event, j'ai créé des fonctions dans mes contrôleurs pour les récupérer et les afficher individuellement :


```public function index(ActuRepository $actuRepository): Response
    {
        $actualites = $actuRepository->findAll();

        return $this->render('actualite/nosActus.html.twig', [
            'controller_name' => 'ActualiteController',
            'actualites' => $actualites,
        ]);
    }```

``` #[Route('/actualite/{id<\d+>}', name: 'actu_description')]

    public function actu_description(Actu $actu): Response
    {
        return $this->render('actualite/actuCard.html.twig', [
            'actu' => $actu,
        ]);
    }```

J'ai adapté mes anciens templates avec Bootstrap et utilisé des getters pour afficher les éléments. Pour tester les fonctionnalités, j'ai utilisé des fixtures pour remplir les entités, en gardant mes photos originales.

```for ($i = 0; $i < self::NB_ACTU; $i++) {
            $actu = new Actu();
            $actu
                ->setTitle($faker->realTextBetween(3, 10))
                ->setTextContent($faker->realTextBetween(500, 1400));

            $manager->persist($actu);
        }

        for ($i = 0; $i < self::NB_EVENT; $i++) {
            $event = new Event();
            $event
                ->setEventName($faker->realTextBetween(3, 10))
                ->setDescription($faker->realTextBetween(500, 1400))
                ->setEventDate($faker->dateTimeBetween('2023-12-23', '2024-01-24')); 

            $manager->persist($event);

        }```


## Partie Contact et Page d'Accueil

La création d'un formulaire de contact a été réalisée avec ```php bin/console make:form```. Pour la mise en valeur des événements sur la page d'accueil, j'ai intégré un carrousel Bootstrap qui affiche dynamiquement tous les événements. La structure du carrousel a été modifiée pour inclure une boucle Twig, permettant le défilement automatique de chaque événement. Voici le code du carrousel adapté :


```<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    {% for event in events %}
      <div class="carousel-item {% if loop.first %}active{% endif %}">
        <img src="{{ asset('upload/img_event/' ~ event.getEventImage()) }}" alt="{{ event.getEventName() }}" class="d-block w-100">
        <div class="position-absolute top-0 start-0 w-100 text-white py-2 px-4" style="background-color: rgba(0, 0, 0, 0.5); font-size: 40px;">
          {{ event.getEventName() }}
        </div>
      </div>
    {% endfor %}
  </div>
</div>```

Cette structure permet non seulement d'afficher chaque événement de manière attrayante, mais assure également une navigation fluide et interactive pour les visiteurs du site.

Intégration de l'API de Calendrier

En conclusion de ce projet, la dernière étape consistait à intégrer une API de calendrier pour référencer tous les événements dans la section administration. Pour cela, j'ai choisi d'utiliser FullCalendar. Dans mon contrôleur, j'ai programmé une boucle pour assembler un tableau contenant les titres de tous les événements. Ensuite, j'ai converti ce tableau en format JSON et l'ai transmis au calendrier. Grâce à cette intégration, je suis désormais capable de visualiser l'ensemble des événements directement dans mon interface administrateur.

```public function calendar(EventRepository $eventRepository): Response
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
```;

