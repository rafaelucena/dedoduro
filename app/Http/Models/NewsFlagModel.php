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
 * @ORM\Table(name="news_flag")
 * @ORM\HasLifecycleCallbacks()
 */
class NewsFlagModel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @var integer
     * @ORM\Column(type="smallint", nullable=false)
     */
    public $isImported;

    /**
     * @var integer
     * @ORM\Column(type="smallint", nullable=false)
     */
    public $isSuggested;

    /**
     * @var integer
     * @ORM\Column(type="smallint", nullable=false)
     */
    public $isUseful;

    /**
     * @var integer
     * @ORM\Column(type="smallint", nullable=false)
     */
    public $isActive;

    /**
     * @var integer
     * @ORM\Column(type="smallint", nullable=false)
     */
    public $isReviewed;

    /**
     * @var integer
     * @ORM\Column(type="smallint", nullable=false)
     */
    public $isRelevant;

    /**
     * @var integer
     * @ORM\Column(type="smallint", nullable=false)
     */
    public $isOutdated;

    /**
     * @var integer
     * @ORM\Column(type="smallint", nullable=false)
     */
    public $isChecked;

    /**
     * @var integer
     * @ORM\Column(type="smallint", nullable=false)
     */
    public $isValid;

    /**
     * @var integer
     * @ORM\Column(type="smallint", nullable=false)
     */
    public $isBroken;

    /**
     * @var integer
     * @ORM\Column(type="smallint", nullable=false)
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
    public $reviewedAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $checkedAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $deletedAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="newsFlags")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    public $createdBy;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="newsFlags")
     * @ORM\JoinColumn(name="reviewed_by", referencedColumnName="id", nullable=true)
     */
    protected $reviewedBy;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="newsFlags")
     * @ORM\JoinColumn(name="checked_by", referencedColumnName="id", nullable=true)
     */
    protected $checkedBy;

    /**
     * @var News
     * @ORM\OneToOne(targetEntity="News", mappedBy="flag")
     */
    protected $news;

    /**
     * NewsFlagModel constructor.
     */
    public function __construct()
    {
        $this->isActive = (int) false;
        $this->isImported = (int) false;
        $this->isRelevant = (int) false;
        $this->isSuggested = (int) false;
        $this->isUseful = (int) false;
        $this->isValid = (int) true;

//        $this->createdBy = auth()->user();
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->isBroken = (int) false;
        $this->isChecked = (int) false;
        $this->isDeleted = (int) false;
        $this->isOutdated = (int) false;
        $this->isReviewed = (int) false;

        $this->createdAt = new DateTime();
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
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     *
     * @return NewsFlagModel
     */
    public function setCreatedBy(User $createdBy): NewsFlagModel
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return News
     */
    public function getNews(): News
    {
        return $this->news;
    }
}
