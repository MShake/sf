<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\ChatGroup", mappedBy="users")
     */
    protected $chatGroups;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=150)
     */
    protected $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=150)
     */
    protected $lastname;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="user")
     */
    protected $messages;

    public function __construct()
    {
    	parent::__construct();
    	  $this->messages = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->roles = array('ROLE_USER');
    }

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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }


    /**
     * Add message
     *
     * @param \AppBundle\Entity\Message $message
     *
     * @return User
     */
    public function addMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \AppBundle\Entity\Message $message
     */
    public function removeMessage(\AppBundle\Entity\Message $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add chatGroup
     *
     * @param \AppBundle\Entity\ChatGroup $chatGroup
     *
     * @return User
     */
    public function addChatGroup(\AppBundle\Entity\ChatGroup $chatGroup)
    {
        $this->ChatGroups[] = $chatGroup;

        return $this;
    }

    /**
     * Remove chatGroup
     *
     * @param \AppBundle\Entity\ChatGroup $chatGroup
     */
    public function removeChatGroup(\AppBundle\Entity\ChatGroup $chatGroup)
    {
        $this->ChatGroups->removeElement($chatGroup);
    }

    /**
     * Get chatGroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChatGroups()
    {
        return $this->ChatGroups;
    }
}
