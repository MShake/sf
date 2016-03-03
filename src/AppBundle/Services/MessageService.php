<?php

namespace AppBundle\Services;

use AppBundle\Entity\Message;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class MessageService 
{
    
    protected $em;
    protected $mailer;

    public function __construct(EntityManager $em, $mailer)
    {
        $this->em = $em;
        $this->mailer  = $mailer;
    }
    
    public function add($message_id)
    {
        $message = $this->em->getRepository('AppBundle:Message')->find($message_id);

        $message->setReport(1);
        $this->em->flush();
         $mail = \Swift_Message::newInstance()
        ->setSubject('Hello Email')
        ->setFrom('admin@lolochat.com')
        ->setTo('kalimerre@gmail.com')
        ->setBody('test mail',
            'text/html'
        );
        $this->mailer->send($mail);

    }
    
}
