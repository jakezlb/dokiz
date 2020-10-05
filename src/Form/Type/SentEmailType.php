<?php

namespace App\Form\Type;

use App\Entity\Society;
use App\Entity\SentEmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SentEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder     
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
                'label' => 'Email *'
                
            ])  
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
            'data_class' => SentEmail::class,           
        ]);
    }
}
