<?php

namespace App\Controller;

use App\Entity\InfoRegistration;
use App\Form\InfoRegistrationType;
use App\Repository\InfoSessionDayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mailer\MailerInterface;
use Flasher\Prime\FlasherInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class InfoRegistrationController extends AbstractController
{
    #[Route('/vie-scolaire/inscription', name: 'app_info_registration')]
    public function index(Request $request, PageRepository $pageRepository, EntityManagerInterface $em, MailerInterface $mailer, FlasherInterface $flasher, InfoSessionDayRepository $infoSessionDayRepository): Response
    {
        $page = $pageRepository->findOneBy(['slug' => 'inscription']);

        $registration = new InfoRegistration();
        $form = $this->createForm(InfoRegistrationType::class, $registration);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($registration);
            $em->flush();

            $email = (new TemplatedEmail())
                ->from('no-reply@collegedubiereau.be')
                ->to(new Address('xribant@gmail.com'))
                ->subject('Confirmation d\'inscription à la séance d\'info du : '.$registration->getInfoSessionDay()->getSessionDate()->format('d/m/Y'))
                ->htmlTemplate('documents/registration_confirmation.html.twig')
                ->context([
                    'registration' => $registration
                ])
            ;

            try {
                $mailer->send($email);
                
                $flasher
                    ->options([
                        'timeout' => 5000,
                        'position' => 'top-center'
                    ])
                    ->addSuccess('Votre inscription a bien été enregistrée, vous allez recevoir un e-mail de confirmation.')
                ;

                return $this->redirectToRoute('app_home');

            } catch (TransportExceptionInterface $e) {
                $flasher
                    ->options([
                        'timeout' => 5000,
                        'position' => 'top-center'
                    ])
                    ->addError('<strong>'.$e->getMessage().'</strong>')
                ;
            }

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front_page/index.html.twig', [
            'page' => $page,
            'info_session_days' => $infoSessionDayRepository->findBy(['enabled' => true]),
            'form' => $form->createView(),
        ]);
    }
}
