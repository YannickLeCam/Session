<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Votre prénom ne peut pas être vide']),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Votre prénom doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Votre prénom ne peut pas dépasser {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]+$/u',
                        'message' => 'Votre prénom ne peut contenir que des lettres',
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Votre nom ne peut pas être vide']),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Votre nom doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Votre nom ne peut pas dépasser {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]+$/u',
                        'message' => 'Votre nom ne peut contenir que des lettres',
                    ]),
                ],
            ])
            ->add('email', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'L\'adresse email est obligatoire']),
                    new Email(['message' => 'Veuillez entrer une adresse email valide']),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-check-input'],
                'constraints' => [
                    new IsTrue(['message' => 'Vous devez accepter nos conditions.']),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-control', 'autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer un mot de passe']),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/',
                        'message' => 'Votre mot de passe doit contenir au moins une lettre majuscule, un chiffre et un caractère spécial',
                    ]),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['class' => 'form-control', 'autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez confirmer votre mot de passe']),
                    new EqualTo([
                        'propertyPath' => 'plainPassword',
                        'message' => 'Les mots de passe doivent être identiques',
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
