<?php

namespace App\Form;

use App\Entity\PreferenceQuotation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreferenceQuotationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text_introduction',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Texte d\'introduction par défaut'
            ])
            ->add('text_conclusion',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Texte de conclusion par défaut'
            ])
            ->add('pied_page',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Pied de page par défaut'
            ])
            ->add('conditions_generales',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Conditions générales de vente par défaut'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PreferenceQuotation::class,
        ]);
    }
}
