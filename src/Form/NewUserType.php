<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class NewUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Ex: big-mac@mcdonald.com',
                'class' => 'form-control'
            ]
        ])
        ->add('firstName', TextType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Ex: Ronald',
                'class' => 'form-control'
            ]
        ])
        ->add('lastName', TextType::class, [
            'label' => false,
            'attr' => [
                'placeholder' => 'Ex: McDonald',
                'class' => 'form-control'
            ]
        ])
        ->add('roles', ChoiceType::class, [
            'label' => false,
            'expanded' => false,
            'multiple' => false,
            'choices' => [
                'Utilisateur' => 'ROLE_USER',
                'Administrateur' => 'ROLE_ADMIN'
            ],
            'attr' => [
                'class' => 'form-control'
            ]
        ]);

        // Data transformer
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                     // transform the array to a string
                     return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                     // transform the string back to an array
                     return [$rolesString];
                }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
