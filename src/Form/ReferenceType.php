<?php

namespace App\Form;

use App\Entity\Reference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'attr' => [
                    'class' => 'uk-input'
                ]
            ])
            ->add('customer', TextType::class, [
                'attr' => [
                    'class' => 'uk-input'
                ]
            ])
            ->add('mission', TextareaType::class, [
                'attr' => [
                    'class' => 'uk-textarea ckeditor'
                ]
            ])
            ->add('imageFile', FileType::class, [
                'attr' => [
                    'class' => 'uk-form-file'
                ],
                'label' => ' '
            ])
            ->add('link', UrlType::class, [
                'attr' => [
                    'class' => 'uk-input'
                ]
            ])
            ->add('imageHeight', NumberType::class, [
                'attr' => [
                    'class' => 'uk-input'
                ]
            ])
            ->add('captionImage', TextType::class, [
                'attr' => [
                    'class' => 'uk-input'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reference::class,
        ]);
    }
}
