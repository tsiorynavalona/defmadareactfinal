<?php

namespace App\EventSubscriber;

use App\Entity\BlogPost;
use App\Entity\ImagePost;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;

class SetImageSubscriber implements EventSubscriberInterface
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
    public function onAfterEntityUpdatedEvent($event)
    {
        // ...
    }

    public static function getSubscribedEvents()
    {
        return [
            AfterEntityUpdatedEvent::class => 'setImageAfterupdate',
            AfterEntityPersistedEvent::class => 'setImageAfterPersist',
        ];
    }

    public function setImageAfterUpdate(AfterEntityUpdatedEvent $event) {
        $entity = $event->getEntityInstance();
        if($entity instanceof BlogPost) {
            $url = $entity->photoFilename;
            $em = $this->managerRegistry->getManager();
            $image = new ImagePost();
            $image->setUrl($url);
            $entity->setImage($image);
            $em->persist($image);
            $em->flush();
        }
    
        

    }

    public function setImageAfterPersist(AfterEntityPersistedEvent $event) {
        $entity = $event->getEntityInstance();
    
        if($entity instanceof BlogPost) {
            $url = $entity->photoFilename;
            $em = $this->managerRegistry->getManager();
            $image = new ImagePost();
            $image->setUrl($url);
            $entity->setImage($image);
            $em->persist($image);
            $em->flush();
        }

    }
}
