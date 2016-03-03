<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Message;

class LoadMessageData extends AbstractFixture implements OrderedFixtureInterface {
	
	public function load(ObjectManager $manager) {
		$contents = array (
				'Quisque tortor mauris, cursus suscipit quam id, rhoncus aliquet tortor. Nulla lobortis eu elit a feugiat. Nulla laoreet massa sed diam varius dictum.',
				'Sed et ante pharetra, porta ante placerat, bibendum magna.',
				'Proin faucibus sollicitudin eros, ut fringilla arcu accumsan et.',
				'Phasellus eget efficitur nisl. Vivamus in lobortis sem. Duis velit ligula, tristique nec lacinia et, viverra id elit.',
				'Curabitur in dignissim urna. Donec dignissim commodo tellus.',
				'Fusce sed efficitur est, at consequat magna. Nullam auctor a nunc ac dictum. Nunc quis mi at eros malesuada lobortis ac at sem.',
				'Duis ac fringilla diam.',
				'Donec purus nulla, facilisis quis feugiat et, dictum vel purus. In euismod mattis ornare. Mauris condimentum fermentum vehicula.',
				'Etiam eget scelerisque lorem. Nunc convallis felis eu nisl fringilla convallis.',
				'Mauris semper felis eget aliquet ullamcorper.',
				'Curabitur eros est, faucibus id tincidunt non, interdum ac lectus.',
				'Morbi a leo non turpis volutpat varius. Nulla vel metus eget nisi euismod luctus in nec neque.',
				'Aliquam ultricies tempus orci sed lobortis.',
				'Vestibulum id magna auctor, mattis ligula non, feugiat felis.',
				'Etiam nisi magna, volutpat porta ultricies placerat, porta ut eros.',
				'Morbi id quam eget quam feugiat accumsan. Aliquam blandit orci diam, hendrerit molestie velit venenatis eget.',
				'Vestibulum id magna auctor, mattis ligula non, feugiat felis.',
				'Donec risus mauris, tincidunt id fringilla sit amet, elementum ut metus.' 
		);
		
		for($i = 0; $i < 18; $i ++) {
			$message = new Message ();
			$message->setContent ( $contents [$i] );
			if ($i < 9) {
				$message->setChatGroup ( $this->getReference ( "groups0" ) );
				if ($i < 3) {
					$message->setUser ( $this->getReference ( "users0" ) );
				} else if ($i < 6) {
					$message->setUser ( $this->getReference ( "users1" ) );
				} else {
					$message->setUser ( $this->getReference ( "users2" ) );
				}
			} else {
				$message->setChatGroup ( $this->getReference ( "groups1" ) );
				if ($i < 13) {
					$message->setUser ( $this->getReference ( "users0" ) );
				} else {
					$message->setUser ( $this->getReference ( "users3" ) );
				}
			}
                        
                        $message->setReport(0);
			
			$manager->persist ( $message );
		}
		
		$manager->flush ();
	}
	
	public function getOrder() {
		// the order in which fixtures will be loaded
		// the lower the number, the sooner that this fixture is loaded
		return 3;
	}
}
