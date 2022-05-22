<?php

namespace App\Form;

use App\Entity\Deposit;
use App\Repository\PreferenceDepositRepository;
use App\Repository\PreferenceGeneralRepository;
use App\Repository\QuotationRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DepositType extends AbstractType
{
    private $text_introduction;
    private $text_conclusion;
    private $pied_page;
    private $montant_payer;
    private $preferenceGeneralRepository;


    public function __construct(PreferenceDepositRepository $preferenceDepositRepository, PreferenceGeneralRepository $preferenceGeneralRepository){
        $this->text_introduction = $preferenceDepositRepository->find(1)->getTextIntroduction();
        $this->text_conclusion = $preferenceDepositRepository->find(1)->getTextConclusion();
        $this->pied_page = $preferenceDepositRepository->find(1)->getPiedPage();
        $this->montant_payer = $preferenceDepositRepository->find(1)->getMontantPayer();
        $this->preferenceGeneralRepository = $preferenceGeneralRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant_payer',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'data' => $this->montant_payer,
                'label' => 'Montant à payer (€)'
            ])
            ->add('tva_non_applicable',null,[
                'label' => 'TVA non applicable ',
                'attr' => [
                    'class' => 'form-check-input'
                ],
                'data' => $this->preferenceGeneralRepository->find(1)->getTvaNonApplicable(),
                'required' => false,
            ])
            ->add('tva',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'data' => $this->preferenceGeneralRepository->find(1)->getTva(),
                'label' => 'TVA (%)'
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
                'label' => 'Texte d\'introduction (visible sur la facture d\'acompte)'
            ])
            ->add('text_conclusion',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'data' => $this->text_conclusion,
                'label' => 'Texte de conclusion (visible sur la facture d\'acompte)'
            ])
            ->add('pied_page',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'data' => $this->pied_page,
                'label' => 'Pied de page (visible sur la facture d\'acompte)'
            ])
            ->add('quotation',null,[

                'query_builder' => function (QuotationRepository $quotationRepository) {
                    return $quotationRepository->createQueryBuilder('q')
                        ->where('q.state = :state')
                        ->setParameter('state','signé');

                },
                'choice_label' => function ($quotation) {
                    if($quotation->getState() === 'signé'){
                        return $quotation->getNumerotation().' de '.$quotation->calculTotalHt().' € HT';
                    }

                },
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('compte_bancaire',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Compte bancaire (RIB)'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Deposit::class,
        ]);
    }
}
