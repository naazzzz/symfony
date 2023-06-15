<?php

namespace App\EventListener;

use App\Entity\Car;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;


class UpdateSubscriber implements EventSubscriberInterface
{

    public function getSubscribedEvents(): array
    {

        return [
            Events::prePersist,
            Events::postPersist,
        ];
    }

    public function prePersist(PrePersistEventArgs $args): void
    {
//        $user = $args->getObject();
//        if ($user instanceof User) {
//
//            $user->setName('Subscriber');
//        }
    }

    public function postPersist(PostPersistEventArgs $args): void
    {
        $car = $args->getObject();
        if ($car instanceof Car) {

            $car->setDateCreate('2000-01-01');
            $args->getObjectManager()->persist($car);

        }


    }


}