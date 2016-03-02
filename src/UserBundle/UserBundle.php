<?php

namespace UserBundle;

use FOS\UserBundle\FOSUserBundle;

class UserBundle extends FOSUserBundle
{

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
