<?php

namespace App\Form\Type;

use App\Entity\CarRide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarRideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departure')
            ->add('arrival')
            ->add('date_start')
            ->add('date_end')           
            ->add('adress_point_departure')
            ->add('adress_point_arrival')
            ->add('km_number')
            ->add('status')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CarRide::class,
        ]);
    }
}
