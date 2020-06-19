<?php

namespace App\Form\Type;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_reservation', DateTimeType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Date de Réservation'
            ])
            ->add('state_premise_depature', DateTimeType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Date de départ'
            ])
            ->add('state_premise_arrival', DateTimeType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => "Date d'arrivée"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
