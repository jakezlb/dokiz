<?php

namespace App\Form\Type;

use App\Entity\Car;
use App\Entity\Society;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('immatriculation', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required',
                    'maxlength'=> 7
                ],
            ])
            ->add('place_number', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required',
                    'placeholder' => 'Ex : Renault - ENI - 2020'
                ],
            ])            
            ->add('keys', CollectionType::class, [
                'entry_type' => KeyCarType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                
            ])
            ->add('fuel', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])            
            ->add('date_commissioning', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
            ->add('mark', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
            ->add('parked', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
            ->add('assurance', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
            ->add('technical_control', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required',
                    'placeholder' => 'Ex : Rayures, Accidents'
                ],
            ])
            ->add('society', EntityType::class, [
                'class' => Society::class,
                'attr' => [
                    'class' => 'form-control',
                    'required'=>'required'
                ]
            ])
            ->add('car_url', FileType::class, [
                'label' => 'Miniature voiture',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF/JPG/PNG document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
