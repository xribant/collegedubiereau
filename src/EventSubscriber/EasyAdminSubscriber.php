<?php
# src/EventSubscriber/EasyAdminSubscriber.php
namespace App\EventSubscriber;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private SluggerInterface $slugger,
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setPagePath'],
        ];
    }

    public function setPagePath(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Page)) {
            return;
        }

        $slug = $this->slugger->slug($entity->getTitle());
        $entity->setSlug(strtolower($slug));
        $entity->setPath('/'.$entity->getParentMenu()->getSlug().'/'.strtolower($slug));
    }
}