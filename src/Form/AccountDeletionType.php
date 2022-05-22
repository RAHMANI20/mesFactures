<?php

namespace App\Form;

use App\Entity\AccountDeletion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AccountDeletionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raison',ChoiceType::class,[
                'choices'  => [
                    'Je rencontre des problèmes techniques' => 'Je rencontre des problèmes techniques' ,'Le site ne répond pas à mes attentes' => 'Le site ne répond pas à mes attentes','J\'ai un autre compte' => 'J\'ai un autre compte','Autre' => 'Autre'
                ],
                'label' => 'Raisons (requis)',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('remarque',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Remarques'
            ])
            ->add('password',PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ])
                ],
                'label' => 'Mot de passe (requis)'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AccountDeletion::class,
        ]);
    }
}
