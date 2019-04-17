<?php

namespace LogementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LocaleControllerTest extends WebTestCase
{
    public function testSwitch()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/switch');
    }

}
