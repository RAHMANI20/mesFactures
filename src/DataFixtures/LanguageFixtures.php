<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $language1 = new Language();
        $language1->setLangue('Français');
        $language2 = new Language();
        $language2->setLangue('Anglais');
        $manager->persist($language1);
        $manager->persist($language2);

        $manager->flush();
    }
}
