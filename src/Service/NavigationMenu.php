<?php

namespace App\Service;

use App\Entity\Menu;
use App\Repository\MenuRepository;

class NavigationMenu
{
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function getNavigationMenu() {
        $menus = $this->menuRepository->findAll();
        return $menus;
    }
}