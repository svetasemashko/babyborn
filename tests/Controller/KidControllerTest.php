<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class KidControllerTest extends WebTestCase
{
    public function testNewPositive(): void
    {
        $client = static::createClient();
        $client->request('GET', '/kid/new');

        $this->assertResponseIsSuccessful();
    }
}
