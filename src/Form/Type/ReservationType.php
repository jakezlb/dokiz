<?php

namespace App\Form\Type;

use App\Entity\Reservation;

use Doctrine\DBAL\Types\ObjectType;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('carRides', CollectionType::class, [
                // each entry in the array will be an "email" field-
                'entry_type' => CarRideType::class,
                // these options are passed to each "email" type
                'entry_options' => [
                    'attr' => ['class' => 'form-control'],
                ],
            ])

            ->add('cars', CollectionType::class, [
                // each entry in the array will be an "email" field-
                'entry_type' => CarType::class,
                // these options are passed to each "email" type
                'entry_options' => [
                    'attr' => ['class' => 'form-control'],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'csrf_protection' => false,
        ]);
    }
}
