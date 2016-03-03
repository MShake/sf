<?php

namespace AppBundle\Controller;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Message;
use AppBundle\Entity\ChatGroup;
use AppBundle\Entity\User;
use AppBundle\Form\CreateMessageForm;
use AppBundle\Form\AddGroupForm;
use AppBundle\Repository\MessageRepository;
use AppBundle\Repository\ChatGroupRepository;
use AppBundle\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



class MessageController extends Controller{

	private $messages = null;
	private $groups = null;
	private $groupLoad = null;
	private $current_group = null;
	private $groupLastMessage = null;
	private $repoMessage = null;
	private $repoChatGroup = null;
    private $repoUser = null;

    /**
     * @Route("/", name="message")
     * @Template()
     */
    public function messageAction(Request $request){
        $message = new Message();
        $group = new ChatGroup();

        $form = $this->createForm(CreateMessageForm::Class, $message);
        $form2 = $this->createForm(AddGroupForm::Class, $group);

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $this->initRepo();

        $this->groupLastMessage = $this->repoMessage->findGroupLastMessageSend($user);
       	
        $groupFind = false;
        if(count($this->groupLastMessage)>0) {
        	//Recherche du plus récent message envoyé sur un groupe actif
        	for($i=0; $i<count($this->groupLastMessage); $i++){
        		$this->groupLoad = $this->repoChatGroup->find($this->groupLastMessage[$i]->getChatGroup()->getId());
        		if($this->groupLoad->getEnable()){
        			$groupFind = true;
        			break;
        		}
        	}
        	
        	if($groupFind){
        		$this->initGroupsAndMessages($this->groupLoad, $this->repoMessage, $this->repoChatGroup,$this->repoUser);
        		$this->groupLoad = $this->groupLoad->getId();
        	}
        }

        return $this->constructArrayValues($form,$form2, $user->getId());
    }

    /**
     * @Route("/group/{id_group}", name="group")
     * @Template("AppBundle:Message:message.html.twig")
     * @ParamConverter("group", class="AppBundle:ChatGroup", options={"id" = "id_group"})
     */
    public function groupAction(Request $request, ChatGroup $group){
        $message = new Message();

        $form = $this->createForm(CreateMessageForm::Class, $message);
        $form2 = $this->createForm(AddGroupForm::Class, $group);

        $form->handleRequest($request);
        $user_id = $this->get('security.token_storage')->getToken()->getUser()->getId();

        if($form->isSubmitted() && $form->isValid()){
            $this->saveMessage($message, $group);
        }

        $this->initRepo();
        $this->initGroupsAndMessages($group, $this->repoMessage, $this->repoChatGroup,$this->repoUser);
        $this->groupLoad = $group->getId();

        return $this->constructArrayValues($form,$form2, $user_id);
    }

    /**
     * @Route("/add/group", name="groupAdd")
     * @Template("AppBundle:Message:message.html.twig")
     */
    public function addGroupAction(Request $request){
        $message = new Message();
        $group = new ChatGroup();

        $form = $this->createForm(CreateMessageForm::Class, $message);
        $form2 = $this->createForm(AddGroupForm::Class, $group);

        $form2->handleRequest($request);

        if($form2->isSubmitted() && $form2->isValid()){
            $this->saveChatGroup($group);
        }
        $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

        return $this->redirect($root."group/".$group->getId());
    }


    private function constructArrayValues(Form $form,Form $form2 ,$user_id){
    	return array(
    			'form' => $form->createView(),
                'form2' => $form2->createView(),
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

    private function saveChatGroup(ChatGroup $chatGroup){
        $em = $this->get('doctrine')->getManager();
        $chatGroup->addUser($this->getUser());
        $em->persist($chatGroup);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Groupe ajouté');
    }


    private function initGroupsAndMessages(ChatGroup $group, MessageRepository $repoMessage, ChatGroupRepository $repoChatGroup,UserRepository $repoUser){

        $user = $repoUser->find($this->getUser()->getId());
        $this->groups = $user->getChatGroups();
    	$this->current_group = $repoChatGroup->find($group->getId());
    	$this->messages = $repoMessage->findBy(
    			array('chatGroup' => $group),
    			array('dateCreated' => 'asc'));
    }

    private function initRepo(){
    	$this->repoMessage = $this->get('doctrine')->getManager()->getRepository('AppBundle:Message');
    	$this->repoChatGroup = $this->get('doctrine')->getManager()->getRepository('AppBundle:ChatGroup');
        $this->repoUser = $this->get('doctrine')->getManager()->getRepository('AppBundle:User');
    }

    /**
     * @Route("/report/{id_message}/{id_group}", name="report_message")
     * @Template("AppBundle:Message:test_report.html.twig")
     */
    public function reportMessage($id_message, $id_group){
        $report = $this->get("lolochat.messageservice");
        $report->add($id_message);

		$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

        return $this->redirect($root."group/".$id_group);
    }
}
