<?php

namespace App\Form;

use App\Entity\Company;
use App\Repository\PreferenceGeneralRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    private $preferenceGeneralRepository;

    public function __construct(PreferenceGeneralRepository $preferenceGeneralRepository){
        $this->preferenceGeneralRepository = $preferenceGeneralRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de la société (requis)'
            ])
            ->add('num_tva',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Numéro de TVA'
            ])
            ->add('siret',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'SIREN, SIRET...'
            ])
            ->add('code_naf',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Code NAF, NACE, NOGA...'
            ])
            ->add('adresse',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Adresse'
            ])
            ->add('complement_adresse',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Complément d\'adresse'
            ])
            ->add('code_postal',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Code postal'
            ])
            ->add('ville',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Ville'
            ])
            ->add('pays',CountryType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'preferred_choices' => function ($choice, $key, $value) {
                    return $choice === $this->preferenceGeneralRepository->find(1)->getPays();
                },
                'label' => 'Pays'
            ])
            ->add('num_telephone',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Numéro de téléphone'
            ])
            ->add('site_internet',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Site internet'
            ])
            ->add('langue',null,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Langue'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
