<?php

namespace App\Form;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\PreferenceGeneralRepository;
use App\Repository\TypeArticleRepository;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    private $preferenceGeneralRepository;

    public function __construct(PreferenceGeneralRepository $preferenceGeneralRepository){
        $this->preferenceGeneralRepository = $preferenceGeneralRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type_article',null,[
                'query_builder' => function (TypeArticleRepository $typeArticleRepository) {
                    return $typeArticleRepository->createQueryBuilder('t')->orderBy('t.nom','ASC');
                },
                'preferred_choices' => function ($choice, $key, $value) {
                    return $choice === $this->preferenceGeneralRepository->find(1)->getTypeArticle();
                },
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Type'
            ])
            ->add('quantite',null,[
                'attr' => [
                    'class' => 'form-control col-md-3'
                ],
                'label' => 'Quantité'
            ])
            ->add('prix_ht',null,[
                'attr' => [
                    'class' => 'form-control col-md-3',

                 ],
                'label' => 'Prix HT'
            ])
            ->add('tva',null,[
                'attr' => [
                    'class' => 'form-control col-md-3'
                ],
                'data' => $this->preferenceGeneralRepository->find(1)->getTva(),
                'label' => 'TVA (%)'
            ])
            ->add('reduction',null,[
                'attr' => [
                    'class' => 'form-control col-md-3'
                ],
                'label' => 'Réduction (%)'
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
            'data_class' => Article::class,
        ]);
    }
}
