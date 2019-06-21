<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Votre prénom'
                ]
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Votre email'
                ]
            ])
            ->add('organisation', TextType::class, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Votre organisation'
                ]
            ])
            ->add('subject', ChoiceType::class, [
                'choices' => [
                    'Demande d\'informations' => 'infos',
                    'Demande de devis' => 'devis',
                ],
                'attr' => [
                    'class' => 'uk-select'
                ]
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Votre adresse'
                ]
            ])
            ->add('codePostal', TextType::class, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Votre code postal'
                ]
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Votre ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'preferred_choices' => ['FR'],
                'attr' => [
                    'class' => 'uk-select'
                ]
            ])
            ->add('Content', TextareaType::class, [
                'attr' => [
                    'class' => 'uk-textarea',
                    'rows' => '10',
                    'cols' => '30',
                    'placeholder' => 'Votre message'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
