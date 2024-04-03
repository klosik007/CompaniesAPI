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
    #[Route('/companies', name: 'get_all_companies_info', methods: ['GET'])]
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

    #[Route('/company/{id}', name: 'update_company', methods: ['PATCH'])]
    public function updateCompany(EntityManagerInterface $entityManager,
                                  CompanyRepository $companyRepository,
                                  Request $request, int $id): Response
    {
        $companyData = $companyRepository->find($id);
        if (!$companyData)
        {
            return new Response('Company data not found', 404);
        }

        $companyUpdatedData = json_decode($request->getContent(), true);

        if (isset($companyUpdatedData['name'])) {
            $companyData->setName($companyUpdatedData['name']);
        }

        if (isset($companyUpdatedData['address'])) {
            $companyData->setAddress($companyUpdatedData['address']);
        }

        if (isset($companyUpdatedData['nip'])) {
            $companyData->setNIP($companyUpdatedData['nip']);
        }

        if (isset($companyUpdatedData['postal'])) {
            $companyData->setPostal($companyUpdatedData['postal']);
        }

        $entityManager->flush();

        return new Response('Updated company with id: '.$id);
    }

    #[Route('/company/{id}', name: 'delete_company', methods: ['DELETE'])]
    public function deleteCompany(EntityManagerInterface $entityManager,
                                  CompanyRepository $companyRepository, int $id): Response
    {
        $companyData = $companyRepository->find($id);
        if (!$companyData)
        {
            return new Response('Company data not found', 404);
        }

        $entityManager->remove($companyData);
        $entityManager->flush();

        return new Response('Deleted company with id: '.$id);
    }
}
