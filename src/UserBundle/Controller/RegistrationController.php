<?php


namespace UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;


class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        if($this->getUser())
        {
            // redirect authenticated users to homepage
            return $this->redirect($this->generateUrl('message'));
        }
        return parent::registerAction($request);
    }
}
