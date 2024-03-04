<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\DataFixtures\CompanyFixtures;
use App\DataFixtures\EmployeeFixtures;
use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class EmployeeEntityDbTest extends ApiTestCase
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

    public function testDeleteEmployee(): void
    {
        $this->databaseTool->loadFixtures([
            CompanyFixtures::class,
            EmployeeFixtures::class
        ]);

        $addedEmployee = $this->entityManager->getRepository(Employee::class)->findOneBy([
            'name' => 'Kłos',
        ]);
        $this->entityManager->remove($addedEmployee);
        $this->entityManager->flush();
        $deletedEmployee = $this->entityManager->getRepository(Employee::class)->findOneBy([
            'name' => 'Kłos',
        ]);
        $this->assertNull($deletedEmployee);
    }

    public function testEmployeeIsAddedSuccessfullyAndExists() : void
    {
        $this->databaseTool->loadFixtures([
            CompanyFixtures::class,
            EmployeeFixtures::class
        ]);

        $addedCompany = $this->entityManager->getRepository(Employee::class)->findOneBy([
            'name' => 'Kłos',
        ]);

        $this->assertNotNull($addedCompany);
    }

    public function testCompanyUpdateIsSuccessful(): void
    {
        $this->databaseTool->loadFixtures([
            CompanyFixtures::class,
            EmployeeFixtures::class
        ]);

        $company = $this->entityManager->getRepository(Employee::class)->findOneBy([
            'name' => 'Kłos',
        ]);

        $company->setName('Baszczyński');
        $this->entityManager->flush();

        $companyUpdated = $this->entityManager->getRepository(Employee::class)->findOneBy([
            'name' => 'Baszczyński',
        ]);

        $this->assertNotNull($companyUpdated);
    }
}
