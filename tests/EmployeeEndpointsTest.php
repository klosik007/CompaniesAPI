<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class EmployeeEndpointsTest extends ApiTestCase
{
    public function testCreateEmployee(): void
    {
        $response = static::createClient()->request('POST', '/employee', [
            'headers' => ['Content-Type' => 'application/json'],
            'json'=> [
                "name" => "Kłos",
                "surname" => "Janek",
                "email" => "pklos1992@gmail.com",
                "phone" => "512655101",
                "company_id" => 1
            ]
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testGetAllEmployees(): void
    {
        $response = static::createClient()->request('GET', '/employee/all')->toArray();

        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey(0, $response);
    }

    public function testGetEmployeeById(): void
    {
        $response = static::createClient()->request('GET', '/employee/1')->toArray(); //TODO: should be last id or something like that

        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('id', $response);
    }

    public function testUpdateEmployee(): void
    {
        $response = static::createClient()->request('PATCH', '/employee/1', [ //TODO: should be last id or something like that
            'headers' => ['Content-Type' => 'application/json'],
            'json'=> [
                "email" => "pklos@gmail.com",
            ]
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testDeleteEmployee(): void
    {
        $response = static::createClient()->request('DELETE', '/employee/1'); //TODO: should be last id or something like that

        $this->assertResponseIsSuccessful();
    }
}
