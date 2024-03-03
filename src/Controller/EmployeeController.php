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
}
