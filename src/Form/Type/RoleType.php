<?php

namespace App\Form\Type;

use App\Entity\User;
use App\Entity\Society;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\User\UserInterface;

class RoleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class,[
            'constraints' => [
                new NotBlank([
                    'message' => 'Merci d\'entrer un e-mail',
                ]),
            ],
            'required' => true,
            'attr' => ['class' =>'form-control'],
        ])
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
        ->add('phone', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'required'=>'required'
            ],
        ]) 
        ->add('roles', ChoiceType::class, [
            'choices' => [
                'Utilisateur' => 'ROLE_USER',
                'Super Admin' => 'ROLE_SUPERADMIN',
                'Administrateur' => 'ROLE_ADMIN'
            ],
            'expanded' => true,
            'multiple' => true,
            'label' => 'Rôles' 
        ])
        ->add('password', PasswordType::class)
        ->add('society', EntityType::class, [
            'class' => Society::class,
            'attr' => [
                'class' => 'form-control',
                'required'=>'required'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
