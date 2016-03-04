<?php

namespace tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MessageControllerTest extends WebTestCase {
	public function testIndex() {
		$client = static::createClient ();
		
		$crawler = $client->request ( 'GET', '/login' );
		
		$this->assertGreaterThan ( 0, $crawler->filter ( 'html:contains("Identifiant")' )->count () );
	}
}
