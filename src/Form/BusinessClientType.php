<?php

namespace App\Form;

use App\Entity\BusinessClient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Adresse email',
                'required' => false
            ])
            ->add('prenom',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prénom (requis)'
            ])
            ->add('nom',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de famille (requis)'
            ])
            ->add('fonction',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Fonction'
            ])
            ->add('langue',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Langue'
            ])
            ->add('num_telephone',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Numéro de téléphone'
            ])
            ->add('societe',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => ''
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BusinessClient::class,
        ]);
    }
}
