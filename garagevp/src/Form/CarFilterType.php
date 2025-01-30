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
               'label' => 'Marque',
               'choices' => [
                   'Peugeot' => 'Peugeot',
                   'Renault' => 'Renault',
                   'Citroën' => 'Citroën', 
                   'Volkswagen' => 'Volkswagen',
                   'BMW' => 'BMW',
                   'Audi' => 'Audi',
                   'Opel' => 'Opel', 
                   'Porsche' => 'Porsche',
                   'Dacia' => 'Dacia', 
                   'Seat' => 'Seat',
               ],
               'required' => false,
               'placeholder' => 'Choisir une marque'
           ])
           ->add('engineType', ChoiceType::class, [
               'label' => 'Type de moteur',
               'choices' => [
                   'Diesel' => 'diesel',
                   'Essence' => 'essence',
               ],
               'required' => false,
               'placeholder' => 'Choisir un type de moteur'
           ])
           ->add('year', IntegerType::class, [
               'label' => 'Année',
               'required' => false,
               'attr' => [
                   'placeholder' => 'Année du véhicule'
               ]
           ])
           ->add('mileage', IntegerType::class, [
               'label' => 'Kilométrage',
               'required' => false,
               'attr' => [
                   'placeholder' => 'Kilométrage maximum'
               ]
           ])
           ->add('price', IntegerType::class, [
               'label' => 'Prix',
               'required' => false,
               'attr' => [
                   'placeholder' => 'Prix maximum'
               ]
           ])
           ->add('submit', SubmitType::class, [
               'label' => 'Rechercher'
           ]);
   }

   public function configureOptions(OptionsResolver $resolver)
   {
       $resolver->setDefaults([
           'data_class' => null,
       ]);
   }
}
