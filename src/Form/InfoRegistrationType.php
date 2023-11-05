<?php

namespace App\Form;

use App\Entity\InfoRegistration;
use App\Entity\InfoSessionDay;
use App\Entity\Section;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfoRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre Prénom'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre Nom'
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Téléphone'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'E-Mail'
                ]
            ])
            ->add('child_number', ChoiceType::class, [
                'label' => false,
                'placeholder' => 'Nombre d\'enfants à inscrire',
                'expanded' => false,
                'multiple' => false,
                'choices' => [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('sections', EntityType::class, [
                'label' => 'Je souhaite inscrire mon/mes enfant(s) en',
                'multiple' => true,
                'expanded' => false,
                'class' => Section::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.shortName', 'ASC');
                },
                'choice_label' => 'fullName',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('info_session_day', EntityType::class, [
                'label' => false,
                'placeholder' => 'Je m\'inscris à la séance d\'info du',
                'class' => InfoSessionDay::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('day')
                        ->where('day.enabled = true')
                        ->orderBy('day.session_date', 'ASC');
                },
                'choice_label' => function($day) {
                    $dateFormatter = \IntlDateFormatter::create(
                        'fr_BE',
                        \IntlDateFormatter::FULL,
                        \IntlDateFormatter::NONE,
                        'Europe/Brussels',
                        \IntlDateFormatter::GREGORIAN
                    );
                    return $dateFormatter->format($day->getSessionDate());
                },
                'attr' => [
                    'class' => 'form-control'
                ],
                'choice_translation_domain' => true,
                'translation_domain' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InfoRegistration::class,
            'translation_domain' => 'messages'
        ]);
    }
}
