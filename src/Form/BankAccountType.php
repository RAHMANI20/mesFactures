<?php

namespace App\Form;

use App\Entity\BankAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BankAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iban',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'IBAN (requis)'
            ])
            ->add('bic',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'BIC (requis)'
            ])
            ->add('titulaire',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Titulaire (requis)'
            ])
            ->add('libelle',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Libellé du compte (requis)'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BankAccount::class,
        ]);
    }
}
