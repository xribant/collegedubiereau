<?php

namespace App\Controller\Admin;

use App\Entity\MenuEntry;
use App\Form\MenuEntryType;
use App\Repository\MenuEntryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/menu')]
class MenuEntryController extends AbstractController
{
    #[Route('/', name: 'app_menu_entry_index', methods: ['GET'])]
    public function index(MenuEntryRepository $menuEntryRepository): Response
    {
        return $this->render('admin/menu_entry/index.html.twig', [
            'menu_entries' => $menuEntryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_menu_entry_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $menuEntry = new MenuEntry();
        $form = $this->createForm(MenuEntryType::class, $menuEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($menuEntry);
            $entityManager->flush();

            return $this->redirectToRoute('app_menu_entry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/menu_entry/new.html.twig', [
            'menu_entry' => $menuEntry,
            'form' => $form,
        ]);
    }

    #[Route('/{uid}/edit', name: 'app_menu_entry_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MenuEntry $menuEntry, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MenuEntryType::class, $menuEntry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_menu_entry_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/menu_entry/edit.html.twig', [
            'menu_entry' => $menuEntry,
            'form' => $form,
        ]);
    }

    #[Route('/{uid}', name: 'app_menu_entry_delete', methods: ['POST'])]
    public function delete(Request $request, MenuEntry $menuEntry, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menuEntry->getUid(), $request->request->get('_token'))) {
            $entityManager->remove($menuEntry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_menu_entry_index', [], Response::HTTP_SEE_OTHER);
    }
}
