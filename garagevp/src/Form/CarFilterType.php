<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', ChoiceType::class, [
                'choices' => [
                    'Peugeot' => 'Peugeot',
                    'Renault' => 'Renault',
                    'Citroën' => 'Citroën',
                    'Volkswagen' => 'Volkswagen',
                    'BMW' => 'BMW',
                    'Audi' => 'Audi',
                ],
                'required' => false,
                'placeholder' => 'Choose a brand',
            ])
            ->add('engineType', ChoiceType::class, [
                'choices' => [
                    'Diesel' => 'diesel',
                    'Essence' => 'essence',
                ],
                'required' => false,
                'placeholder' => 'Choose engine type',
            ])
            ->add('year', IntegerType::class, [
                'required' => false,
                'placeholder' => 'Year',
            ])
            ->add('mileage', IntegerType::class, [
                'required' => false,
                'placeholder' => 'Mileage',
            ])
            ->add('price', IntegerType::class, [
                'required' => false,
                'placeholder' => 'Max price',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Filter',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
