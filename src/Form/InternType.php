<?php

namespace App\Form;

use App\Entity\Intern;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InternType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'attr' => [
                    'class' => 'form-control', 
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom ne peut pas etre vide',
                    ]),
                ],
            ])
            ->add('firstName',TextType::class,[
                'attr' => [
                    'class' => 'form-control', 
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom ne peut pas etre vide',
                    ]),
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                    'Autre' => 'Autre',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le genre ne peut pas être vide',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('email',EmailType::class,[
                'attr' => [
                    'class' => 'form-control', 
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'email ne peut pas etre vide',
                    ]),
                    new Email([
                        'message' => "Le mail ne semble de ne être valide",
                    ]),
                ],
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control', 
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date d\'anniversaire ne peut pas etre vide',
                    ]),
                ],
            ])
            ->add('city',TextType::class,[
                'attr' => [
                    'class' => 'form-control', 
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom de la ville ne peut pas etre vide',
                    ]),
                ]
            ])
            ->add('adress',TextType::class,[
                'attr' => [
                    'class' => 'form-control', 
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'adress ne peut pas etre vide',
                    ]),
                ]
            ])

            ->add('zipCode',TextType::class,[
                'attr' => [
                    'class' => 'form-control', 
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le code postal ne peut pas etre vide',
                    ]),
                ]
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
            'data_class' => Intern::class,
        ]);
    }
}
