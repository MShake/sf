<?php

/**
 * Created by PhpStorm.
 * User: lionel
 * Date: 01/03/2016
 * Time: 18:33
 */
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\ChatGroup;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadGroupFixtures extends AbstractFixture implements OrderedFixtureInterface {

	function load(ObjectManager $manager) {

		$groupnames = array (
				'Potes',
				'ESGI',
		);

		$i = 0;

		while ( $i < 2 ) {
			$chatGroup = new ChatGroup ();
			$chatGroup->setName ($groupnames[$i]);

			if ($i == 0) {
				$chatGroup->addUser ( $this->getReference ( "users0" ) );
				$chatGroup->addUser ( $this->getReference ( "users1" ) );
				$chatGroup->addUser ( $this->getReference ( "users2" ) );
			} else {
				$chatGroup->addUser ( $this->getReference ( "users0" ) );
				$chatGroup->addUser ( $this->getReference ( "users3" ) );
			}

			$this->addReference ( 'groups' . $i, $chatGroup );
			$manager->persist ( $chatGroup );
			$i ++;
		}
		$manager->flush ();
	}

	public function getOrder() {
		// the order in which fixtures will be loaded
		// the lower the number, the sooner that this fixture is loaded
		return 2;
	}
}
