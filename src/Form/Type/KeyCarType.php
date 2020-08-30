<?php

namespace App\Form\Type;

use App\Entity\KeyCar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KeyCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de la clé'
            ])
        
            ->add('is_taken', ChoiceType::class, [
                'choices'  => [
                    'Disponible' => 0,
                    'Indisponible' => 1,
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Disponibilité'
            ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => KeyCar::class,
        ]);
    }
}
