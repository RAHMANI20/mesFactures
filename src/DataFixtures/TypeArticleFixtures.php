<?php

namespace App\DataFixtures;

use App\Entity\TypeArticle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $type1 = new TypeArticle();
        $type1->setNom('Acompte');
        $type1->getState('fixed');
        $type2 = new TypeArticle();
        $type2->setNom('Heures');
        $type2->getState('fixed');
        $type3 = new TypeArticle();
        $type3->setNom('Jours');
        $type3->getState('fixed');
        $type4 = new TypeArticle();
        $type4->setNom('Produit');
        $type4->getState('fixed');
        $type5 = new TypeArticle();
        $type5->setNom('Service');
        $type5->getState('fixed');

        $manager->persist($type1);
        $manager->persist($type2);
        $manager->persist($type3);
        $manager->persist($type4);
        $manager->persist($type5);

        $manager->flush();
    }
}
