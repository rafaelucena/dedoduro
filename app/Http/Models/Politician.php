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
 * @ORM\Table(name="politician")
 * @ORM\HasLifecycleCallbacks()
 */
class Politician
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    public $isActive;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    public $isDeleted;

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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="politicians")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    public $createdBy;

    /**
     * @var Persona
     * @ORM\ManyToOne(targetEntity="Persona", inversedBy="politicians")
     */
    public $persona;

    /**
     * @var Party
     * @ORM\ManyToOne(targetEntity="Party", inversedBy="politicians")
     */
    protected $party;

    /**
     * @var PoliticianRole
     * @ORM\ManyToOne(targetEntity="PoliticianRole", inversedBy="politicians")
     */
    protected $role;

    public function __construct()
    {
        //@TODO
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->createdAt = new DateTime();
        $this->createdBy = auth()->user();
        $this->isDeleted = (int) false;
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

    /**
     * @return PoliticianRole
     */
    public function getRole(): PoliticianRole
    {
        return $this->role ? : new PoliticianRole();
    }

    /**
     * @param PoliticianRole $role
     *
     * @return Politician
     */
    public function setRole(PoliticianRole $role): Politician
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Party
     */
    public function getParty(): Party
    {
        return $this->party ? : new Party();
    }

    /**
     * @param Party $party
     * @return Politician
     */
    public function setParty(Party $party): Politician
    {
        $this->party = $party;
        return $this;
    }
}
