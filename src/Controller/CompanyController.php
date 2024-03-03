<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CompanyController extends AbstractController
{
    #[Route('/company/all', name: 'get_all_companies_info', methods: ['GET'])]
    public function getAllCompaniesInfo(CompanyRepository $companyRepository): JsonResponse
    {
        $allData = $companyRepository->findAll();

        return $this->json($allData);
    }

    #[Route('/company/{id}', name: 'get_company_info', methods: ['GET'])]
    public function getCompanyInfo(CompanyRepository $companyRepository, int $id): JsonResponse
    {
        $companyData = $companyRepository->find($id);

        return $this->json($companyData);
    }
}
