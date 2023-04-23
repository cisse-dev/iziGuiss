<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categories;

class Product1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ]

        ])
        ->add('description', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ]

        ])
        ->add('price', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ]

        ])
        ->add('picture', TextType::class, [
            'attr' => [
                'class' => 'form-control'
            ]

        ])
        ->add('fk_category', EntityType::class, [
            'class' => Categories::class,
            'choice_label' => function (Categories $category) {
                return $category->getNom();
            },
            'choice_value' => 'id',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

    

