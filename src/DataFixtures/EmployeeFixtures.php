<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Employee;
use App\Repository\CompanyRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $employee1 = new Employee();
        $employee1->setName("Kłos");
        $employee1->setSurname("Przemysław");
        $employee1->setEmail("pklos1992@gmail.com");
        $employee1->setPhone("512655100");
        $employee1->addCompany($this->getReference(CompanyFixtures::COMPANY1_REFERENCE));
        $manager->persist($employee1);

        $employee2 = new Employee();
        $employee2->setName("Wartnicki");
        $employee2->setSurname("Bartek");
        $employee2->setEmail("bwartnicki@gmail.com");
        $employee2->setPhone("694568897");
        $employee2->addCompany($this->getReference(CompanyFixtures::COMPANY2_REFERENCE));
        $manager->persist($employee2);

        $manager->flush();
    }
}
