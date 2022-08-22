<?php

declare(strict_types=1);

namespace App\Tests\Basic;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SwaggerTest extends WebTestCase
{
    public function test_swagger_is_working(): void
    {
        $client = static::createClient();

        $client->request('GET', '/swagger');
        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(200, (string) $client->getResponse()->getStatusCode());
    }
}
