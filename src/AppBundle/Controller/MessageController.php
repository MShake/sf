<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Message;
use AppBundle\Entity\ChatGroup;
use AppBundle\Form\CreateMessageForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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
        $groups = $this->get('doctrine')->getManager()->getRepository('AppBundle:ChatGroup')->findAll();
        $messages = "";
        $user_id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        return array(
            'form' => $form->createView(),
            'groups' => $groups,
            'messages' => $messages,
            'user_id' => $user_id
        );
        
    }
    
    /**
     * @Route("/group/{id_group}", name="group")
     * @Template("AppBundle:Message:messages.html.twig")
     * @ParamConverter("group", class="AppBundle:ChatGroup", options={"id" = "id_group"})
     */
    public function groupAction(Request $request, ChatGroup $group)
    {
        $message = new Message();
        $form = $this->createForm(CreateMessageForm::Class, $message);
        
        $form->handleRequest($request);
        $user_id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->get('doctrine')->getManager();

            $message->setUser($this->getUser());
            $message->setChatGroup($group);
            $em->persist($message);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Message ajouté');
            return $this->redirect($this->generateUrl('group', array('id_group' => $group->getId())));
        }
        $groups = $this->get('doctrine')->getManager()->getRepository('AppBundle:ChatGroup')->findAll();
        $current_group = $this->get('doctrine')->getManager()->getRepository('AppBundle:ChatGroup')->find($group->getId());
        $repo = $this->get('doctrine')->getManager()->getRepository('AppBundle:Message');
        $messages = $repo->findBy(
                array('chatGroup' => $group),
                array('dateCreated' => 'asc'));
        //$messages = "";
        return array(
            'form' => $form->createView(),
            'groups' => $groups,
            'messages' => $messages,
            'id_group' => $group->getId(),
            'current_group' => $current_group,
            'user_id' => $user_id
        );
    }
    
}
