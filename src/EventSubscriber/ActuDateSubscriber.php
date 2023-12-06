<?php


namespace App\EventSubscriber;

use App\Entity\Actu;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;


class ActuDateSubscriber implements EventSubscriberInterface
{

    public function getSubscribedEvents(): array
    {
        return [
            Events:: prePersist,
        ];
    }
    public function prePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();
        if (!$entity instanceof Actu) {
            return ;
        }
        $entity->setPublicationDate(new \DateTime());
    }


}