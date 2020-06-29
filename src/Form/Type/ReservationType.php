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
           
            ->add('status_key', ChoiceType::class, [
                'choices'  => [
                    'Demander' => 'Demander',
                    'En cours d\'utilisation' => 'En cours d\'utilisation',
                    'Rendu' => 'Rendu',
                ],
                'attr' => [
                    'class' => 'form-control'                   
                ],                               
                'label' => 'Statut de la clé de la voiture'
            ])
            ->add('state_premise_depature', DateTimeType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'widget' => 'single_text',
                'label' => 'Date'
            ])
            ->add('state_premise_arrival', DateTimeType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'widget' => 'single_text',
                'label' => "Date"
            ])
            ->add('carRides', CollectionType::class, [
                'entry_type' => CarRideType::class,
                'entry_options' => [
                    'attr' => ['class' => 'form-control']
                ],
                'allow_add' => true,
                'allow_delete' => true
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
