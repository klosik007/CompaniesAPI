<?php

namespace App\Controller;

use App\Repository\EmployeeRepository;
use App\Entity\Employee;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends AbstractController
{
    #[Route('/employee/all', name: 'get_all_employees_info')]
    public function getAllEmployeesInfo(EmployeeRepository $employeeRepository): JsonResponse
    {
        $employeesAllData = $employeeRepository->findAll();

        return $this->json($employeesAllData);
    }

    #[Route('/employee/{id}', name: 'get_employee_info', methods: ['GET'])]
    public function getEmployeeInfo(EmployeeRepository $companyRepository, int $id): JsonResponse
    {
        $employeeData = $companyRepository->find($id);

        return $this->json($employeeData);
    }

    #[Route('/employee', name: 'create_employee', methods: ['POST'])]
    public function createEmployee(EntityManagerInterface $entityManager, CompanyRepository $companyRepository, Request $request): Response
    {
        $employeeData = json_decode($request->getContent(), true);

        $employee = new Employee();
        $employee->setName($employeeData['name']);
        $employee->setSurname($employeeData['surname']);
        $employee->setEmail($employeeData['email']);
        $employee->setPhone($employeeData['phone']);

        $company_id = $employeeData['company_id'];
        $company = $companyRepository->find($company_id);

        if (isset($company))
            $employee->addCompany($company);
        else
            return new Response('Cannot find the company with id '.$company_id, 404);

        $entityManager->persist($employee);
        $entityManager->persist($company);
        $entityManager->flush();

        return new Response('Added new employee with id: '.$employee->getId());
    }

    #[Route('/employee/{id}', name: 'update_employee', methods: ['PATCH'])]
    public function updateEmployee(EntityManagerInterface $entityManager, CompanyRepository $companyRepository, Request $request, int $id): Response
    {
        $employeeData = $entityManager->getRepository(Employee::class)->find($id);
        if (!$employeeData)
        {
            return new Response('Employee data not found', 404);
        }

        $employeeUpdatedData = json_decode($request->getContent(), true);

        if (isset($employeeUpdatedData['name'])) {
            $employeeData->setName($employeeUpdatedData['name']);
        }

        if (isset($employeeUpdatedData['surname'])) {
            $employeeData->setSurname($employeeUpdatedData['surname']);
        }

        if (isset($employeeUpdatedData['email'])) {
            $employeeData->setEmail($employeeUpdatedData['email']);
        }

        if (isset($employeeUpdatedData['phone'])) {
            $employeeData->setPhone($employeeUpdatedData['phone']);
        }

        if (isset($employeeUpdatedData['company_id'])) {
            $oldCompany = $employeeData->getCompany()->get(0); // get previously saved Company object
            $newCompany = $companyRepository->find($employeeUpdatedData['company_id']);

            if (isset($newCompany)) {
                $employeeData->removeCompany($oldCompany); //old dependency
                $employeeData->addCompany($newCompany); //new dependency
            }
            else
                return new Response('Cannot find the company with id '.$employeeUpdatedData['company_id'], 404);
        }

        $entityManager->flush();

        return new Response('Updated employee with id: '.$id);
    }


}
