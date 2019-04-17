<?php

namespace LogementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LogementAdminControllerTest extends WebTestCase
{
    public function testShowlogement()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showLogement');
    }

}
