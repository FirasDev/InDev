<?php

namespace EventBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationControllerTest extends WebTestCase
{
    public function testValidation()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/validation');
    }

}
