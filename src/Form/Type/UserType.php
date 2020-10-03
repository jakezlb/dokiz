<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
                'label' => 'Nom *'
            ])
            ->add('firstName', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
                'label' => 'Prénom *'
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
                'label' => 'Email *'
                
            ]) 
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=> 'required'
                ],
                'label' => 'Téléphone *'
            ])    
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de passe *'
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Confirmer le mot de passe *'
                ]
            ])
            ;
                
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'usePassword' => true
        ]);
    }
}
