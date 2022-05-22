<?php

namespace App\DataFixtures;

use App\Entity\BusinessClient;
use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BusinessClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
            $businessClient1 = new BusinessClient();
            $businessClient1->setNom('rahmani');
            $businessClient1->setPrenom('faical');
            $businessClient2 = new BusinessClient();
            $businessClient2->setNom('rahmani');
            $businessClient2->setPrenom('habib');
            $businessClient3 = new BusinessClient();
            $businessClient3->setNom('rahmani');
            $businessClient3->setPrenom('mohamed');

            $manager->persist($businessClient1);
            $manager->persist($businessClient2);
            $manager->persist($businessClient3);

            $manager->flush();
    }

    public function getDependencies(){
        return [
            LanguageFixtures::class
        ];
    }
}
