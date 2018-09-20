<?php

namespace App\Http\Models;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="persona_action")
 * @ORM\HasLifecycleCallbacks()
 */
class PersonaAction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    public $isActive;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="personasNews")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    protected $createdBy;

    /**
     * @var Persona
     * @ORM\ManyToOne(targetEntity="Persona", inversedBy="personaActions")
     */
    protected $persona;

    /**
     * @var PersonaActionType
     * @ORM\ManyToOne(targetEntity="PersonaActionType", inversedBy="personaActions")
     */
    protected $personaActionType;

    /**
     * @var Action
     * @ORM\ManyToOne(targetEntity="Action", inversedBy="personaActions")
     */
    protected $action;

    /**
     * PersonaAction constructor.
     */
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
        $this->isActive = (int) true;
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
     * @return Action
     */
    public function getAction(): Action
    {
        return $this->action;
    }

    /**
     * @param Action $action
     *
     * @return PersonaAction
     */
    public function setAction(Action $action): PersonaAction
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return Persona
     */
    public function getPersona(): Persona
    {
        return $this->persona;
    }

    /**
     * @param Persona $persona
     *
     * @return PersonaAction
     */
    public function setPersona(Persona $persona): PersonaAction
    {
        $this->persona = $persona;

        return $this;
    }

    /**
     * @return PersonaActionType
     */
    public function getPersonaActionType(): PersonaActionType
    {
        return $this->personaActionType ? : new PersonaActionType();
    }

    /**
     * @param PersonaActionType $personaActionType
     * @return PersonaAction
     */
    public function setPersonaActionType(PersonaActionType $personaActionType): PersonaAction
    {
        $this->personaActionType = $personaActionType;
        return $this;
    }
}
