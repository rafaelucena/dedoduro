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
 * @ORM\Table(name="news")
 * @ORM\HasLifecycleCallbacks()
 */
class News
{
    public const RELATED_POLITICIANS = 'politicians';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    public $title;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    public $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=511, nullable=false, unique=true)
     */
    public $url;

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
    public $publishedAt;

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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="news")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    protected $createdBy;

    /**
     * @var Source
     * @ORM\ManyToOne(targetEntity="Source", inversedBy="news")
     */
    protected $source;

    /**
     * @var ArrayCollection|PersonaNews[]
     * @ORM\OneToMany(targetEntity="PersonaNews", mappedBy="news")
     */
    protected $personaNews;

    /**
     * Slug constructor.
     */
    public function __construct()
    {
//        $this->news = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->createdAt = new DateTime();
        $this->createdBy = auth()->user();
        $this->isActive = (int) true;
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
     * @return Source
     */
    public function getSource(): Source
    {
        return $this->source;
    }

    /**
     * @param Source $source
     *
     * @return News
     */
    public function setSource(Source $source): News
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return PersonaNews[]|ArrayCollection
     */
    public function getPersonaNews()
    {
        $criteria = custom_criteria(['isActive' => true, 'isDeleted' => false]);

        return $this->personaNews->matching($criteria);
    }

    public function getPersonas(string $related = '')
    {
        $activeRelations = $this->getPersonaNews();

        $personas = [];
        foreach ($activeRelations as $activeRelation) {
            $persona = $activeRelation->getPersona();

            switch ($related) {
                case self::RELATED_POLITICIANS:
                    if ($persona->getPolitician() !== false) {
                        $personas[] = $persona;
                    }
                    break;
                default:
                    $personas[] = $persona;
                    break;
            }
        }

        return $personas;
    }
}
