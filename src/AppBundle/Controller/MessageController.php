<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Message;
use AppBundle\Form\CreateMessageForm;

class MessageController extends Controller
{
    /**
     * @Route("/", name="message")
     * @Template("AppBundle:Message:messages.html.twig")
     */
    public function messageAction(Request $request)
    {
        $message = new Message();
        
               
        $form = $this->createForm(CreateMessageForm::Class, $message);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->get('doctrine')->getManager();
            //$message->setMessage($form->content);
            $em->persist($message);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Message ajotué');
            return $this->redirectToRoute('message');
        }
        
        return array(
            'form' => $form->createView(),
        );
        
    }
    
}
