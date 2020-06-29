<?php

namespace App\Form\Type;

use App\Entity\CarRide; 
use App\Entity\Status;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CarRideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('postal_code_point_departure', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Code postal de la ville de départ'
            ])
            ->add('city_point_departure', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Ville de départ'
            ])
            ->add('adress_point_departure', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Adresse de départ'
            ])
            ->add('postal_code_point_arrival', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Code postal de la ville d\'arrivée'
            ])
            ->add('city_point_arrival', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Ville d\'arrivée'
            ])
            ->add('adress_point_arrival', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Adresse d\'arrivée'
            ])
            ->add('km_number', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => "Nombre de kilomètres"
            ])
            ->add('status', EntityType::class, [
                'class' => Status::class,
                'attr' => [
                    'class' => 'form-control'                   
                ],                               
                'label' => 'Statut du trajet'
            ])
            ->add('date_start', DateTimeType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'widget' => 'single_text',
                'label' => 'Date de départ'
            ])
            ->add('date_end', DateTimeType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'widget' => 'single_text',
                'label' => 'Date d\'arrivée'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CarRide::class,
        ]);
    }
}
