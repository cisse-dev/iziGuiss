<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
    ->add('lastname',TextType::class,[
        'attr' => [
            'class' => 'form-control'
        ]
      
    ])
        ->add('firstname', TextType::class,[
            'attr' => [
                'class' => 'form-control'
            ]

        ])
        ->add('email', EmailType::class,[
            'attr' => [
                'class' => 'form-control'
            ]
        ])
            ->add('adress', TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
            ->add('zipcode', TextType::class ,[
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
            ->add('phone', TextType::class ,[
                'attr' => [
                    'class' => 'form-control'
                ]

            ])
           

            ->add('password', RepeatedType::class, [
                
                'type' => PasswordType::class,
                
                'first_options' => ['label' => 'Password', 
                'attr' => [
                    'class' => 'form-control'
                ],
            ],

                'second_options' => ['label' => 'Confirm Password', 
                'attr' => [
                    'class' => 'form-control'
                ],
                ]
            ])
            ->add('Connexion', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}