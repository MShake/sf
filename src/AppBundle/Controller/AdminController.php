<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use AppBundle\Entity\Message;
use AppBundle\Entity\ChatGroup;
use AppBundle\Form\EditGroupForm;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\MessageRepository;
use AppBundle\Repository\ChatGroupRepository;

class AdminController extends Controller{
	
	private $repoUser;
	private $repoMessage;
	private $repoChatGroup;
	
	/**
	 * @Route("/admin", name="admin")
	 * @Template()
	 */
	public function indexAction(Request $request){
		
	}
	
	/**
	 * @Route("/admin/groups", name="admin-groups")
	 * @Template()
	 */
	public function groupsAction(){
		$this->initRepo();
		$groups = $this->repoChatGroup->findAll();
		
		return array(
				'groups' => $groups,
		);
	}
	
	/**
	 * @Route("/admin/group/{id}", name="admin-group-edit")
	 * @Template()
	 */
	public function editGroupAction(Request $request, $id){
		$this->initRepo();
		$group = $this->repoChatGroup->find($id);
		$form = $this->createForm(EditGroupForm::Class, $group);
		$form->handleRequest($request);
		if($form->isSubmitted() && $form->isValid()){
			$this->updateChatGroup($group);
			return $this->redirect($this->generateUrl('admin-groups'));
		}
		
		return array(
				'form' => $form->createView(),
				'group' => $group
		);
	}
	
	private function updateChatGroup(ChatGroup $chatGroup){
		$em = $this->get('doctrine')->getManager();
		$em->flush();
		$this->get('session')->getFlashBag()->add('success', 'Groupe modifié');
	}
	
	private function initRepo(){
		$this->repoUser = $this->get('doctrine')->getManager()->getRepository('AppBundle:User');
		$this->repoMessage = $this->get('doctrine')->getManager()->getRepository('AppBundle:Message');
		$this->repoChatGroup = $this->get('doctrine')->getManager()->getRepository('AppBundle:ChatGroup');
	}
}
