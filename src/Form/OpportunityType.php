<?php

namespace App\Form;

use App\Entity\Opportunity;
use App\Repository\PreferenceGeneralRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OpportunityType extends AbstractType
{
    private $preferenceGeneralRepository;

    public function __construct(PreferenceGeneralRepository $preferenceGeneralRepository){

        $this->preferenceGeneralRepository = $preferenceGeneralRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Intitulé (requis)'
            ])
            ->add('montant_ht',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Montant HT (requis)'
            ])
            ->add('devise',CurrencyType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'preferred_choices' => function ($choice, $key, $value) {
                    return $choice === $this->preferenceGeneralRepository->find(1)->getDevise();
                },
                'label' => 'Devise'
            ])
            ->add('mois_signature',ChoiceType::class,[
                'choices'  => [
                    'janvier' => 'janvier','février' => 'février','mars' => 'mars','avril' => 'avril','mai' => 'mai','juin' => 'juin','juillet' => 'juillet','aout' => 'aout','septembre' => 'septembre','octobre' => 'octobre','novembre' => 'novembre','décembre' => 'décembre'
                ],
                'label' => 'Mois de signature prévue',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('annee_signature',ChoiceType::class,[
                'choices'  => [
                    '2022' => '2022','2023' => '2023','2024' => '2024','2025' => '2025','2026' => '2026','2027' => '2027'
                ],
                'label' => 'Année de signature prévue',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('probabilite',RangeType::class,[
                'attr' => [
                    'class' => 'form-range',
                    'onchange' => 'updateInput(this.value);',

                ],
                'label' => 'Probabilité'
            ])
            ->add('notes',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Notes'
            ])
            ->add('destinataire', ChoiceType::class, [
                'choices' => [
                    'client professionnel' => 'professionnel',
                    'client particulier' => 'particulier',
                    'société' => 'societe'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
                'placeholder' => 'Choose an option',
                'mapped' => false,
            ])
            ->add('businessClient',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => ' '
            ])
            ->add('particularClient',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => ' '
            ])
            ->add('company',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => ' '
            ])
            ->add('notes',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Notes'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Opportunity::class,
        ]);
    }
}
