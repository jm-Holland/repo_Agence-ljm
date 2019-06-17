<?php

namespace App\Form;

use App\Entity\Service;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class, [
                'attr' => [
                    'class' => 'uk-input'
                ]
            ])
            ->add('description',TextareaType::class, [
                'attr' => [
                    'class' => 'uk-textarea ckeditor'
                ]
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'uk-textarea ckeditor'
                ]
            ])
            ->add('imageFile', FileType::class, [
                'label' => ' ',
                'required' => false,
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
            'data_class' => Service::class,
        ]);
    }
}
