<?php

namespace App\Form;

use App\Entity\PreferenceGeneral;
use App\Repository\TypeArticleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreferenceGeneralType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pays',CountryType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Pays par défaut pour les clients et sociétés'
            ])
            ->add('devise',CurrencyType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Devise par défaut (requis)'
            ])
            ->add('type_article',null,[
                'query_builder' => function (TypeArticleRepository $typeArticleRepository) {
                    return $typeArticleRepository->createQueryBuilder('t')->orderBy('t.nom','ASC');
                },
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Type d\'article par défaut (requis)'
            ])
            ->add('tva',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'TVA (%) par défaut'
            ])
            ->add('tva_non_applicable',CheckboxType::class,[

                'label' => 'TVA non applicable par défaut',
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'required' => false
            ])
            ->add('text_tva',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Texte affiché lorsque la TVA n\'est pas applicable'
            ])
            ->add('condition_reglement',ChoiceType::class,[
                'choices'  => [
                    'Voir détail ci après' => 'Voir détail ci après','À réception' => 'À réception','Fin de mois' => 'Fin de mois','10 jours' => '10 jours','30 jours'=> '30 jours','30 jours fin de mois'=>'30 jours fin de mois','45 jours'=> '45 jours','45 jours fin de mois'=>'45 jours fin de mois','60 jours'=> '60 jours','60 jours fin de mois'=>'60 jours fin de mois','90 jours'=> '90 jours','90 jours fin de mois'=>'90 jours fin de mois','120 jours'=> '120 jours'
                ],
                'label' => 'Conditions de règlement par défaut',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('mode_reglement',ChoiceType::class,[
                'choices'  => [
                    'Non spécifié' => 'Non spécifié','Espèces' => 'Espèces','Chèque' => 'Chèque','Virement bancaire'=>'Virement bancaire','Carte bancaire'=>'Carte bancaire','PayPal'=>'PayPal','Prélèvement'=>'Prélèvement','Lettre de change'=>'Lettre de change','Lettre de change relevé'=>'Lettre de change relevé','Lettre de change sans acceptation'=>'Lettre de change sans acceptation','Billet à ordre'=>'Billet à ordre'
                ],
                'label' => 'Mode de règlement par défaut',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('interet_retard',ChoiceType::class,[
                'choices'  => [
                    'Pas d\'intérêts de retard' =>'Pas d\'intérêts de retard','1% par mois'=>'1% par mois','1,5% par mois'=>'1,5% par mois','2% par mois'=>'2% par mois','Taux d’intérêt légal en vigueur'=>'Taux d’intérêt légal en vigueur'
                ],
                'label' => 'Intérêts de retard par défaut',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PreferenceGeneral::class,
        ]);
    }
}
