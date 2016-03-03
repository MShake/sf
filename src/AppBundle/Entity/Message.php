<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
{
	
            
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messages")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
	
     /**
     * @ORM\ManyToOne(targetEntity="ChatGroup", inversedBy="messages")
     * @ORM\JoinColumn(name="chat_group_id", referencedColumnName="id")
     */
    protected $chatGroup;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;
    
    /**
     * @var boolean
     * 
     * @ORM\Column(name="report", type="boolean", length=2)
     */
    private $report;
    
    /**
     * @var datetime
     * 
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Message
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Message
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set chatGroup
     *
     * @param \AppBundle\Entity\ChatGroup $chatGroup
     *
     * @return Message
     */
    public function setChatGroup(\AppBundle\Entity\ChatGroup $chatGroup)
    {
        $this->chatGroup = $chatGroup;

        return $this;
    }

    /**
     * Get chatGroup
     *
     * @return \AppBundle\Entity\ChatGroup
     */
    public function getChatGroup()
    {
        return $this->chatGroup;
    }
    
    
    public function __construct()
    {
            $this->setDateCreated(new \DateTime());
    }

    /**
     * Set report
     *
     * @param boolean $report
     *
     * @return Message
     */
    public function setReport($report)
    {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return boolean
     */
    public function getReport()
    {
        return $this->report;
    }
}
