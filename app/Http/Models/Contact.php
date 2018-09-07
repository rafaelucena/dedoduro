<?php

namespace App\Http\Models;

use App\Http\Models\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="contact")
 * @ORM\HasLifecycleCallbacks()
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    public $author;

    /**
     * @var string
     * @ORM\Column(type="string", length=511, nullable=false)
     */
    public $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $subject;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    public $message;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    public $isSent;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    public $isNewsletter;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updatedAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $deletedAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="ContactType", inversedBy="contacts")
     */
    public $contactType;

    public function __construct()
    {
        $this->isNewsletter = (int) false;
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->createdAt = new DateTime();
        $this->isSent = (int) false;
    }

    /**
     * @param PreUpdateEventArgs $eventArgs
     * @ORM\PreUpdate()
     */
    public function onPreUpdate(PreUpdateEventArgs $eventArgs)
    {
        if (!empty($eventArgs->getEntityChangeSet())) {
            $this->updatedAt = new DateTime();
        }
    }
}
