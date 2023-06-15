<?php

namespace App\EventListener;


use App\Entity\ItemsInTheCar;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: User::class)]
class UserEventListener
{

    public function postPersist(User $user, LifecycleEventArgs $event): void
    {
        $event->getObjectManager()->persist(new ItemsInTheCar($user->car));
        $event->getObjectManager()->flush();
    }
}