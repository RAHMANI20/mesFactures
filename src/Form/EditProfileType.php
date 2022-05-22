<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email_pro',EmailType::class,[
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Adresse email professionnelle (apparaît sur les documents)',
            ])
            ->add('prenom',TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Prénom(requis)'
            ])
            ->add('nom',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de famille (requis)'
            ])
            ->add('societe',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Société',
                'required' => false
            ])
            ->add('siret',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'SIRET,SIREN...',
                'required' => false
            ])
            ->add('code_naf',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Code NAF, NACE, NOGA...',
                'required' => false
            ])
            ->add('num_tva',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Numéro de TVA',
                'required' => false
            ])
            ->add('adresse',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Adresse (requis)'
            ])
            ->add('complement_adresse',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Complément d\'adresse',
                'required' => false
            ])
            ->add('code_postal',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Code postal (requis)'
            ])
            ->add('ville',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Ville (requis)'
            ])
            ->add('pays',CountryType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Pays (requis)'
            ])
            ->add('num_telephone',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Numéro de téléphone',
                'required' => false
            ])
            ->add('site_internet',TextType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Site internet',
                'required' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
