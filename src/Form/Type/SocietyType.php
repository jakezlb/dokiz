<?php

namespace App\Form\Type;

use App\Entity\Society;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class SocietyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('siret', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
            ->add('social_reason', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
            ->add('head_office', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
            ->add('postal_code', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
            ->add('email_interlocutor', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
            ->add('tel_interlocutor', TelType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Society::class,
        ]);
    }
}
