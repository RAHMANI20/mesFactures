<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'E-mail'
            ])
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
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'label' => 'En m\'inscrivant à ce site j\'accepte les termes et conditions d\'utilisation',
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Mot de passe'
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
