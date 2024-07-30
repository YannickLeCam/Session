<?php

namespace App\Form;

use App\Entity\Program;
use App\Entity\Session;
use App\Entity\ModuleProgram;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('session', EntityType::class, [
                'class' => Session::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre session ne peut pas etre vide',
                    ]),
                ],
            ])
            ->add('module', EntityType::class, [
                'class' => ModuleProgram::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre module ne peut pas etre vide',
                    ]),
                ],
            ])
            ->add('duration',NumberType::class,[
                'attr'=> [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Votre durée ne peut pas etre vide',
                    ]),
                ],
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
            'data_class' => Program::class,
        ]);
    }
}
