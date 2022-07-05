<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'constraints' => [
                    new Email([
                        'message' => "Make sure your email address is valid.",
                    ]),
                    new NotBlank([
                        'message' => "Please fill out this field.",
                    ]),
                ],
            ])
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Please fill out this field.",
                    ]),
                    new Regex([
                        'pattern' => "/^[a-zA-Z]+-?[a-zA-Z]+$/",
                        'message' => "Please make sure it is a valid name.",
                    ]),
                ],
            ])
            ->add('lastName', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Please fill out this field.",
                    ]),
                    new Regex([
                        'pattern' => "/^[a-zA-Z]+-?[a-zA-Z]+$/",
                        'message' => "Please make sure it is a valid name.",
                    ]),
                ],
            ])
            ->add('phoneNumber', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Please fill out this field.",
                    ]),
                    new Regex([
                        'pattern' => "/^07\d*$/",
                        'message' => "Please make sure it is a valid phone number.",
                    ]),
                    new Length([
                        'min' => 10,
                        'max' => 10,
                    ])
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
