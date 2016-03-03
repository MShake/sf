<?php

namespace AppBundle\Services;

use AppBundle\Entity\Message;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class MessageService 
{
    
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function add($message_id)
    {
        $message = $this->em->getRepository('AppBundle:Message')->find($message_id);

        $message->setReport(1);
        $this->em->flush();
    }
    
}
