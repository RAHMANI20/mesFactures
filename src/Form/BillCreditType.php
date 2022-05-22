<?php

namespace App\Form;

use App\Entity\BillCredit;
use App\Repository\PreferenceBillCreditRepository;
use App\Repository\PreferenceGeneralRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillCreditType extends AbstractType
{
    private $text_introduction;
    private $text_conclusion;
    private $pied_page;
    private $preferenceGeneralRepository;

    public function __construct(PreferenceBillCreditRepository $preferenceBillCreditRepository, PreferenceGeneralRepository $preferenceGeneralRepository){
        $this->text_introduction = $preferenceBillCreditRepository->find(1)->getTextIntroduction();
        $this->text_conclusion = $preferenceBillCreditRepository->find(1)->getTextConclusion();
        $this->pied_page = $preferenceBillCreditRepository->find(1)->getPiedPage();
        $this->preferenceGeneralRepository = $preferenceGeneralRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('devise',CurrencyType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'preferred_choices' => function ($choice, $key, $value) {
                    return $choice === $this->preferenceGeneralRepository->find(1)->getDevise();
                },
                'label' => 'Devise (requis)'
            ])
            ->add('tva_non_applicable', CheckboxType::class, [
                'label' => 'TVA non applicable',
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'data' => $this->preferenceGeneralRepository->find(1)->getTvaNonApplicable(),
                'required' => false,
            ])
            ->add('articles',CollectionType::class,[
                'entry_type' => ArticleType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('disbursements',CollectionType::class,[
                'entry_type' => DisbursementType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('condition_reglement',ChoiceType::class,[
                'choices'  => [
                    'Voir détail ci après' => 'Voir détail ci après','À réception' => 'À réception','Fin de mois' => 'Fin de mois','10 jours' => '10 jours','30 jours'=> '30 jours','30 jours fin de mois'=>'30 jours fin de mois','45 jours'=> '45 jours','45 jours fin de mois'=>'45 jours fin de mois','60 jours'=> '60 jours','60 jours fin de mois'=>'60 jours fin de mois','90 jours'=> '90 jours','90 jours fin de mois'=>'90 jours fin de mois','120 jours'=> '120 jours'
                ],
                'label' => 'Conditions de règlement',
                'preferred_choices' => function ($choice, $key, $value) {
                    return $choice === $this->preferenceGeneralRepository->find(1)->getConditionReglement();
                },
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('mode_reglement',ChoiceType::class,[
                'choices'  => [
                    'Non spécifié' => 'Non spécifié','Espèces' => 'Espèces','Chèque' => 'Chèque','Virement bancaire'=>'Virement bancaire','Carte bancaire'=>'Carte bancaire','PayPal'=>'PayPal','Prélèvement'=>'Prélèvement','Lettre de change'=>'Lettre de change','Lettre de change relevé'=>'Lettre de change relevé','Lettre de change sans acceptation'=>'Lettre de change sans acceptation','Billet à ordre'=>'Billet à ordre'
                ],
                'label' => 'Mode de règlement',
                'preferred_choices' => function ($choice, $key, $value) {
                    return $choice === $this->preferenceGeneralRepository->find(1)->getModeReglement();
                },
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('interet_retard',ChoiceType::class,[
                'choices'  => [
                    'Pas d\'intérêts de retard' =>'Pas d\'intérêts de retard','1% par mois'=>'1% par mois','1,5% par mois'=>'1,5% par mois','2% par mois'=>'2% par mois','Taux d’intérêt légal en vigueur'=>'Taux d’intérêt légal en vigueur'
                ],
                'label' => 'Intérêts de retard',
                'preferred_choices' => function ($choice, $key, $value) {
                    return $choice === $this->preferenceGeneralRepository->find(1)->getInteretRetard();
                },
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('text_introduction',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'data' => $this->text_introduction,
                'label' => 'Texte d\'introduction (visible sur l\'avoir)'
            ])
            ->add('text_conclusion',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'data' => $this->text_conclusion,
                'label' => 'Texte de conclusion (visible sur l\'avoir)'
            ])
            ->add('pied_page',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'data' => $this->pied_page,
                'label' => 'Pied de page (visible sur l\'avoir)'
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BillCredit::class,
        ]);
    }
}
