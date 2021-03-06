<?php

namespace App\Http\Models;

use App\Http\Models\News;
use App\Http\Models\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="source")
 * @ORM\HasLifecycleCallbacks()
 */
class Source
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    public $name;

    /**
     * @var string
     * @ORM\Column(type="string", length=127, nullable=false, unique=true)
     */
    public $shortName;

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
     * @var string
     * @ORM\Column(type="string", length=63, nullable=false, unique=true)
     */
    public $fingerprint;

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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sources")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    protected $createdBy;

    /**
     * @var ArrayCollection|News[]
     * @ORM\OneToMany(targetEntity="News", mappedBy="source")
     */
    protected $news;

    /**
     * Slug constructor.
     */
    public function __construct()
    {
        $this->news = new ArrayCollection();
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
}
