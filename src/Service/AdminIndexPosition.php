<?php
namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

enum Direction
{
    case Top;
    case Up;
    case Down;
    case Bottom;
}

class AdminIndexPosition extends AbstractController {

    public function __construct(
        private readonly EntityManagerInterface $em,
        // private readonly MainMenuRepository $mainMenuRepository,
    ) {
    }

    public function moveTop(AdminContext $context): Response
    {
        return $this->move($context, Direction::Top);
    }

    public function moveUp(AdminContext $context): Response
    {
        return $this->move($context, Direction::Up);
    }

    public function moveDown(AdminContext $context): Response
    {
        return $this->move($context, Direction::Down);
    }

    public function moveBottom(AdminContext $context): Response
    {
        return $this->move($context, Direction::Bottom);
    }

    private function move(AdminContext $context, Direction $direction): Response
    {
        $object = $context->getEntity()->getInstance();
        $newPosition = match($direction) {
            Direction::Top => 0,
            Direction::Up => $object->getPosition() - 1,
            Direction::Down => $object->getPosition() + 1,
            Direction::Bottom => -1,
        };

        $object->setPosition($newPosition);
        $this->em->flush();

        return $this->redirect($context->getReferrer());
    }

}