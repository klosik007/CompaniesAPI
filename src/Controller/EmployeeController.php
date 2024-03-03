<?php

namespace App\Controller;

use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

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
}
