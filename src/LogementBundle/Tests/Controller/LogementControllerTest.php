<?php

namespace LogementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LogementControllerTest extends WebTestCase
{
    public function testAddlogement()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/newlogement');
    }

    public function testShowlogement()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Logements');
    }

}
