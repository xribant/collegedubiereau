<?php

namespace App\EventListener;

use App\Repository\PageRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class SitemapSubscriber implements EventSubscriberInterface
{
    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::class => 'populate',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populate(SitemapPopulateEvent $event): void
    {
        $this->registerPageUrls($event->getUrlContainer(), $event->getUrlGenerator());
    }

    /**
     * @param UrlContainerInterface $urls
     * @param UrlGeneratorInterface $router
     */
    public function registerPageUrls(UrlContainerInterface $urls, UrlGeneratorInterface $router): void
    {
        $pages = $this->pageRepository->findAll();

        foreach ($pages as $page) {
            $pageParentMenu = $page->getParentMenu();
            if($page->getSlug() == 'equipe-educative'){
                $urls->addUrl(
                    new UrlConcrete(
                        $router->generate(
                            'app_front_team',
                            ['menu_slug' => $page->getParentMenu()->getSlug()],
                            UrlGeneratorInterface::ABSOLUTE_URL
                        )
                    ),
                    'page'
                );
            } else if(count($pageParentMenu->getPages()) == 1){
                $urls->addUrl(
                    new UrlConcrete(
                        $router->generate(
                            'app_front_mainpage',
                            ['page_slug' => $page->getSlug()],
                            UrlGeneratorInterface::ABSOLUTE_URL
                        )
                    ),
                    'page'
                );
            } else if(count($pageParentMenu->getPages()) > 1){
                $urls->addUrl(
                    new UrlConcrete(
                        $router->generate(
                            'app_front_subpage',
                            [
                                'menu_slug' => $page->getParentMenu()->getSlug(),
                                'page_slug' => $page->getSlug()
                            ],
                            UrlGeneratorInterface::ABSOLUTE_URL
                        ),
                    ),
                    'page'
                );
            }
        }
    }
}