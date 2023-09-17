<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\NewUserType;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use App\Service\PasswordGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Flasher\Prime\FlasherInterface;

#[Route('/admin/utilisateurs')]
#[UniqueEntity('email')]
class UserController extends AbstractController
{
    /**
    * @var UserPasswordHasherInterface
    */
   private $passwordHasher;

   public function __construct(UserPasswordHasherInterface $passwordHasher)
   {
       $this->passwordHasher = $passwordHasher;
   }

    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'active_menu' => 'users',
            'breadcrumbs' => ['Utilisateurs','Index']
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, MailerInterface $mailer, PasswordGenerator $passwordGenerator, FlasherInterface $flasher): Response
    {
        $user = new User();
        $form = $this->createForm(NewUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Generation d'un mot de passe aléatoire de 10 caractères
            $tempPassword = $passwordGenerator->generatePassword(10);

            // Hash du mot de passe avant insertion en base de données
            $hash = $this->passwordHasher->hashPassword($user, $tempPassword);
            $user->setPassword($hash);

            $user->setUid(uniqid());
            $user->setRoles($user->getRoles());

            // Envoi du mot de passe via e-mail avec lien pour le réinitialiser
            // Send a link by e-mail to the newly created user with a token to activate account and create his/her password
            $email = (new TemplatedEmail())
                ->from('no-reply@collegedubiereau.be')
                ->to($user->getEmail())
                ->subject('College du Biéreau: Activation de votre compte sur collegedubiereau.be')
                ->htmlTemplate('admin/mails/account_activation.html.twig')
                ->context([
                    'user' => $user,
                ]);

            try {
                $mailer->send($email);

                $flasher->options([
                    'timeout' => 5000, // 5 seconds
                ])
                ->addSuccess('<strong>Nouvel utilisateur enregistrée! <br>Un e-mail avec un lien d\'activation a été envoyé.</strong>');

                $userRepository->save($user, true);
            } catch (TransportExceptionInterface $e) {
                $flasher->options([
                    'timeout' => 5000, // 5 seconds
                ])
                ->addError('<strong>'.$e->getMessage().'</strong>');
            }
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'active_menu' => 'users',
            'breadcrumbs' => ['Utilisateurs','Nouveau']
        ]);
    }

    #[Route('/{uid}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'active_menu' => 'users',
            'breadcrumbs' => ['Utilisateurs','Modifier']
        ]);
    }

    #[Route('/{uid}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getUid(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
