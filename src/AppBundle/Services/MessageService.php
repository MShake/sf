<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;

class MessageService
{
    protected $em;
    protected $mailer;

    public function __construct(EntityManager $em, $mailer)
    {
        $this->em = $em;
        $this->mailer = $mailer;
    }

    public function add($message_id)
    {
        $message = $this->em->getRepository('AppBundle:Message')->find($message_id);

        $message->setReport(1);
        $this->em->flush();
        $mail = \Swift_Message::newInstance()
        ->setSubject('Message signalé sur LoloChat')
        ->setFrom('maxime.grimle@creatails.com')
        ->setTo('kalimerre@gmail.com')
        ->setCc(array(
            'fidalgo.antoine@gmail.com' => 'Juanito de paella',
            'laforest.florian@gmail.com' => 'Fake codeur',
            'lionel95200@gmail.com' => 'Lolofeuj',
          ))
        ->setBody('Bonjour <br /><br />
            Un message vient d\'être signalé, voici son contenu : <br /><br />
            <i>'.$message->getContent().'</i><br /><br />Merci<br /><b>Service modération de LoloChat</b>',
            'text/html'
        );
        $this->mailer->send($mail);
    }
}
