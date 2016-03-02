<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseController
{
    public function confirmedAction()
    {
        return $this->render('AppBundle:Message:messages.html.twig');
    }

    public function loginAction(Request $request)
    {
        if($this->getUser())
        {
            // redirect authenticated users to homepage
            return $this->redirect($this->generateUrl('message'));
        }
        return parent::loginAction($request);
    }


}
