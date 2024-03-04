<?php

namespace App\Tests;

use App\DataFixtures\CompanyFixtures;
use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;


class CompanyEntityDbTest extends KernelTestCase
{
    protected AbstractDatabaseTool $databaseTool;
    protected EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->entityManager = static::$kernel->getContainer()->get('doctrine')->getManager();
        $this->databaseTool = static::$kernel->getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function testDeleteCompany(): void
    {
        $this->databaseTool->loadFixtures([
            CompanyFixtures::class
        ]);

        $addedCompany = $this->entityManager->getRepository(Company::class)->findOneBy([
            'name' => 'Igloopol',
        ]);
        $this->entityManager->remove($addedCompany);
        $this->entityManager->flush();
        $deletedCompany = $this->entityManager->getRepository(Company::class)->findOneBy([
            'name' => 'Igloopol',
        ]);
        $this->assertNull($deletedCompany);
    }

    public function testCompanyIsAddedSuccessfullyAndExists() : void
    {
        $this->databaseTool->loadFixtures([
            CompanyFixtures::class
        ]);

        $addedCompany = $this->entityManager->getRepository(Company::class)->findOneBy([
            'name' => 'Igloopol',
        ]);

        $this->assertNotNull($addedCompany);
    }

    public function testCompanyUpdateIsSuccessful(): void
    {
        $this->databaseTool->loadFixtures([
            CompanyFixtures::class
        ]);

        $company = $this->entityManager->getRepository(Company::class)->findOneBy([
            'name' => 'Igloopol',
        ]);

        $company->setName('Vineta');
        $this->entityManager->flush();

        $companyUpdated = $this->entityManager->getRepository(Company::class)->findOneBy([
            'name' => 'Vineta',
        ]);

        $this->assertNotNull($companyUpdated);
    }
}
