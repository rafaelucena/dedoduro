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
 * @ORM\Table(name="persona_slug")
 * @ORM\HasLifecycleCallbacks()
 */
class PersonaSlug
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="personaSlugs")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    public $createdBy;

    /**
     * @var Persona
     * @ORM\ManyToOne(targetEntity="Persona", inversedBy="personaSlugs")
     */
    protected $persona;

    /**
     * @var Slug
     * @ORM\ManyToOne(targetEntity="Slug", inversedBy="personasSlug")
     */
    public $slug;

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
     * @return Persona
     */
    public function getPersona(): Persona
    {
        return $this->persona;
    }

    /**
     * @param Persona $persona
     * @return PersonaSlug
     */
    public function setPersona(Persona $persona): PersonaSlug
    {
        $this->persona = $persona;
        return $this;
    }
}
