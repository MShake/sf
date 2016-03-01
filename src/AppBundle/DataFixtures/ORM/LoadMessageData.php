<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Message;

class LoadMessageData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $contents = array(
            'Quisque tortor mauris, cursus suscipit quam id, rhoncus aliquet tortor. Nulla lobortis eu elit a feugiat. Nulla laoreet massa sed diam varius dictum.',
            'Sed et ante pharetra, porta ante placerat, bibendum magna.',
            'Proin faucibus sollicitudin eros, ut fringilla arcu accumsan et.',
            'Phasellus eget efficitur nisl. Vivamus in lobortis sem. Duis velit ligula, tristique nec lacinia et, viverra id elit.'
            );
        
        foreach($contents as $content)
        {
            $message = new Message();
            $message->setContent($content);
            $manager->persist($message);
        }
        
        $manager->flush();
    }
    
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 3;
    }
}
