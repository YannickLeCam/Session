<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\ModuleProgram;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Email;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre nom ne peut pas etre vide',
                    ]),
                ],
            ])
            ->add('name',TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre nom ne peut pas etre vide',
                    ]),
                ],
            ])
            ->add('email',EmailType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mail ne peut pas être vide.',
                    ]),
                    new Email([
                        'message' => "Le mail ne semble de ne être valide",
                    ]),
                ],
            ])
            ->add('password',PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{12,}$/',
                        'message' => 'Le mot de passe doit contenir au moins 12 caractères, y compris une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
                    ]),
                ],
            ])
            ->add('passwordConfirm',PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe ne peut pas être vide.',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\da-zA-Z]).{12,}$/',
                        'message' => 'Le mot de passe doit contenir au moins 12 caractères, y compris une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
                    ]),
                ],
            ])
            ->add('modulePrograms', EntityType::class, [
                'class' => ModuleProgram::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('Valider',SubmitType::class,[
                'attr' => [
                    'class' => 'btn btn-succes',
                ]
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
