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

    #[Route('/company', name: 'create_company', methods: ['POST'])]
    public function createCompany(EntityManagerInterface $entityManager, Request $request): Response
    {
        $companyData = json_decode($request->getContent(), true);

        $company = new Company();
        $company->setName($companyData['name']);
        $company->setAddress($companyData['address']);
        $company->setNIP($companyData['NIP']);
        $company->setPostal($companyData['postal']);

        $entityManager->persist($company);
        $entityManager->flush();

        return new Response('Added new company with id: '.$company->getId());
    }
}
