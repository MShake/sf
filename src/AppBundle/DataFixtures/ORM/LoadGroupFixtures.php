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


class LoadGroupFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    function load(ObjectManager $manager)
        {

            $i = 1;

            while($i <= 100) {

                $chatGroup = new ChatGroup();
                $chatGroup->setName("Groupe numero ".$i);
                $chatGroup->addUser($this->getReference('user'));
                $manager->persist($chatGroup);
                $i++;
            }
            $manager->flush();
        }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}