<?php

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MessageControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('submit')->form();

        // set some values
        $form['username'] = 'lbueno';
        $form['password'] = 'lolochat';

        $crawler = $client->submit($form);

    }
}
