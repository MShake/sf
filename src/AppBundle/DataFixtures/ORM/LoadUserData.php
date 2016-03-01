<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $firstnames = array('Antoine','Maxime','Florian','Lionel');
        $names = array('FIDALGO','GRIMLER','LAFOREST','BUENO');

        $users = array();

        $i = 0;
        while($i < count($firstnames)){
          $user = new User();

          $user->setFirstname($firstnames[$i]);
          $user->setLastname($names[$i]);
          $user->setEmail($firstnames[$i].'.'.$names[$i].'@lolochat.com');
          $user->setUsername(substr($firstnames[$i], 0, 1).$names[$i]);
          $user->setPlainPassword('lolochat');
          $user->setEnabled(true);

          $manager->persist($user);

          $this->addReference('users'.$i, $user);
          $users[]=$user;
          $i++;
        }

        $admin = new User();

        $admin->setFirstname('admin');
        $admin->setLastname('admin');
        $admin->setEmail('admin@lolochat.com');
        $admin->setUsername('admin');
        $admin->setPlainPassword('admin');
        $admin->setEnabled(true);
        $admin->setSuperAdmin(true);
        $admin->setRoles(array('ROLE_ADMIN'));

        $manager->persist($admin);
        $users[]=$admin;

        $this->addReference('admin', $admin);
        $manager->flush();


    }

    public function getOrder(){
      return 1;
    }
}
