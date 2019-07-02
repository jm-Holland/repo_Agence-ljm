<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CustomerType extends AbstractType
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
            ->add('company', TextType::class, [
                'attr' => [
                    'class' => 'uk-input',
                    'placeholder' => 'Votre entreprise'
                ]
            ])
            ->add('subject', ChoiceType::class, [
                'choices' => [
                    'Demande d\'informations' => "d'information",
                    'Demande de devis' => "de devis",
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
            ->add('postalCode', TextType::class, [
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
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'uk-textarea',
                    'rows' => '6',
                    'placeholder' => 'Votre message'
                ]
            ])
            ->add('agreeRGPD', CheckboxType::class, [
                'required' => true,
                'attr' => [
                    'type' => 'uk-checkbox',
                    'class' => 'uk-checkbox'

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
