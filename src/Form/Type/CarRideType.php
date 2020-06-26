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
                'label' => 'Code Postal'
            ])
            ->add('city_point_departure', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Ville'
            ])
            ->add('adress_point_departure', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Adresse départ'
            ])
            ->add('postal_code_point_arrival', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'CP arrivée'
            ])
            ->add('city_point_arrival', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Ville arrivée'
            ])
            ->add('adress_point_arrival', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => "Adresse arrivée"
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
                        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CarRide::class,
        ]);
    }
}
