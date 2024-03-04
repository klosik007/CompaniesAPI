<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class CompanyEndpointsTest extends ApiTestCase
{
    public function testCreateCompany(): void
    {
        $response = static::createClient()->request('POST', '/company', [
            'headers' => ['Content-Type' => 'application/json'],
            'json'=> [
                "name"=> "nowa nazwa",
                "address"=> "Nowa Huta22",
                "postal"=> "76-200",
                "NIP"=> "9876543210"
            ]
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testGetAllCompanies(): void
    {
        $response = static::createClient()->request('GET', '/company/all')->toArray();

        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey(0, $response);
    }

    public function testGetCompanyById(): void
    {
        $response = static::createClient()->request('GET', '/company/1')->toArray(); //TODO: should be last id or something like that

        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('id', $response);
    }

    public function testUpdateCompany(): void
    {
        $response = static::createClient()->request('PATCH', '/company/1', [ //TODO: should be last id or something like that
            'headers' => ['Content-Type' => 'application/json'],
            'json'=> [
                "name" => "nowa nazwa",
                "address" => "Nowa Huta22",
                "postal" => "76-200",
                "NIP" => "9876543210"
            ]
        ])->toArray();

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteCompany(): void
    {
        $response = static::createClient()->request('DELETE', '/company/1'); //TODO: should be last id or something like that

        $this->assertResponseIsSuccessful();
    }
}
