<?php

namespace App\Http\Models;

use App\Http\Models\News;
use App\Http\Models\Persona;
use App\Http\Models\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="persona_news")
 * @ORM\HasLifecycleCallbacks()
 */
class PersonaNews
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
     * @ORM\ManyToOne(targetEntity="Persona", inversedBy="personaNews")
     */
    protected $persona;

    /**
     * @var News
     * @ORM\ManyToOne(targetEntity="News", inversedBy="personaNews")
     */
    protected $news;

    public function __construct()
    {
        $this->isActive = (int) true;
        $this->createdBy = auth()->user();
        //@TODO
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->createdAt = new DateTime();
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
     * @return News
     */
    public function getNews(): News
    {
        return $this->news;
    }

    /**
     * @param News $news
     *
     * @return PersonaNews
     */
    public function setNews(News $news): PersonaNews
    {
        $this->news = $news;

        return $this;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return PersonaNews
     */
    public function setCreatedBy(User $createdBy): PersonaNews
    {
        $this->createdBy = $createdBy;
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
     * @return PersonaNews
     */
    public function setPersona(Persona $persona): PersonaNews
    {
        $this->persona = $persona;

        return $this;
    }
}
