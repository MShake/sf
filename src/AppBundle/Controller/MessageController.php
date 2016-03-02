<?php

namespace AppBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Message;
use AppBundle\Entity\ChatGroup;
use AppBundle\Form\CreateMessageForm;
use AppBundle\Repository\MessageRepository;
use AppBundle\Repository\ChatGroupRepository;

class MessageController extends Controller{
	
	private $messages = null;
	private $groups = null;
	private $groupLoad = null;
	private $current_group = null;
	private $groupLastMessage = null;
	private $repoMessage = null;
	private $repoChatGroup = null;
	
    /**
     * @Route("/", name="message")
     * @Template()
     */
    public function messageAction(Request $request){
        $message = new Message();
        
        $form = $this->createForm(CreateMessageForm::Class, $message);
        $form->handleRequest($request);

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $this->initRepo();

        $this->groupLastMessage = $this->repoMessage->findGroupLastMessageSend($user);

        if(count($this->groupLastMessage)>0) {
        	$this->groupLoad = $this->repoChatGroup->find($this->groupLastMessage[0]->getChatGroup()->getId());
        	$this->initGroupsAndMessages($this->groupLoad, $this->repoMessage, $this->repoChatGroup);
        	$this->groupLoad = $this->groupLoad->getId();
        }

        return $this->constructArrayValues($form, $user->getId());
    }
    
    /**
     * @Route("/group/{id_group}", name="group")
     * @Template("AppBundle:Message:message.html.twig")
     * @ParamConverter("group", class="AppBundle:ChatGroup", options={"id" = "id_group"})
     */
    public function groupAction(Request $request, ChatGroup $group){
        $message = new Message();
        $form = $this->createForm(CreateMessageForm::Class, $message);
        
        $form->handleRequest($request);
        $user_id = $this->get('security.token_storage')->getToken()->getUser()->getId();
        
        if($form->isSubmitted() && $form->isValid()){
            $this->saveMessage($message, $group);
        }
        
        $this->initRepo();
        $this->initGroupsAndMessages($group, $this->repoMessage, $this->repoChatGroup);
        $this->groupLoad = $group->getId();
        
        return $this->constructArrayValues($form, $user_id);
    }
    
    private function constructArrayValues(Form $form, $user_id){
    	return array(
    			'form' => $form->createView(),
    			'groups' => $this->groups,
    			'messages' => $this->messages,
    			'id_group' => $this->groupLoad,
    			'current_group' => $this->current_group,
    			'user_id' => $user_id
    	);
    }
    
    private function saveMessage(Message $message, ChatGroup $group){
    	$em = $this->get('doctrine')->getManager();
    	
    	$message->setUser($this->getUser());
    	$message->setChatGroup($group);
    	$em->persist($message);
    	$em->flush();
    	
    	$this->get('session')->getFlashBag()->add('success', 'Message ajouté');
    	return $this->redirect($this->generateUrl('group', array('id_group' => $group->getId())));
    }
    
    private function initGroupsAndMessages(ChatGroup $group, MessageRepository $repoMessage, ChatGroupRepository $repoChatGroup){
    	$this->groups = $repoChatGroup->findAll();
    	$this->current_group = $repoChatGroup->find($group->getId());
    	$this->messages = $repoMessage->findBy(
    			array('chatGroup' => $group),
    			array('dateCreated' => 'asc'));
    }
    
    private function initRepo(){
    	$this->repoMessage = $this->get('doctrine')->getManager()->getRepository('AppBundle:Message');
    	$this->repoChatGroup = $this->get('doctrine')->getManager()->getRepository('AppBundle:ChatGroup');
    }
}
