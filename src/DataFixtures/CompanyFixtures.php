<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $company1 = new Company();
        $company1->setName("Igloopol");
        $company1->setAddress("Kolejowa 54");
        $company1->setPostal("00-999");
        $company1->setNIP("0258741369");
        $manager->persist($company1);

        $company2 = new Company();
        $company2->setName("Gnomek");
        $company2->setAddress("Wartowna 54");
        $company2->setPostal("00-777");
        $company2->setNIP("1236547890");
        $manager->persist($company2);

        $manager->flush();
    }
}
