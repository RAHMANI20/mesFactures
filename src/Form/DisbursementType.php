<?php

namespace App\Form;

use App\Entity\Disbursement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DisbursementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference_facture',null,[
                'attr' => [
                    'class' => 'form-control col-md-3'
                ],
                'label' => 'Référence de la facture'
            ])
            ->add('montant_ht',null,[
                'attr' => [
                    'class' => 'form-control col-md-3'
                ],
                'label' => 'Montant HT'
            ])
            ->add('description',TextareaType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Description'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disbursement::class,
        ]);
    }
}
