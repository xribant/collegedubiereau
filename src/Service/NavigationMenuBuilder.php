<?php
namespace App\Service;

use App\Repository\MainMenuRepository;

class NavigationMenuBuilder {

    private $menuRepository;

   public function __construct(MainMenuRepository $menuRepository) {
      $this->menuRepository = $menuRepository;
   }

   public function getNavigationMenu() {
      $navigationMenu = $this->menuRepository->findAll();
      return $navigationMenu;
   }
}