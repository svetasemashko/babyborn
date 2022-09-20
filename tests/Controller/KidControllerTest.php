<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KidControllerTest extends WebTestCase
{
    /**
     * @dataProvider correctRoutes
     */
    public function testNewPositive(string $method, string $route): void
    {
        $client = static::createClient();
        $client->request($method, $route);

        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider incorrectRoutes
     */
    public function testNewNegative(string $method, string $route, int $code): void
    {
        $client = static::createClient();
        $client->request($method, $route);

        $this->assertResponseStatusCodeSame($code);
    }

    public function correctRoutes(): array
    {
        return [
            ['GET', '/kid/new'],
            ['POST', '/kid/new'],
        ];
    }

    public function incorrectRoutes(): array
    {
        return [
            ['GET', '/nnnn', 404],
            ['POST', '/nnnn', 404],
        ];
    }
}
