<?php

namespace App\Http\Models;

use App\Http\Models\User;
use App\Http\Models\CommandHistoryStatusModel as CommandHistoryStatus;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="command_history")
 * @ORM\HasLifecycleCallbacks()
 */
class CommandHistoryModel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    public $signature;

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
     * @var CommandHistoryStatus
     * @ORM\ManyToOne(targetEntity="CommandHistoryStatusModel", inversedBy="commandHistory")
     * @ORM\JoinColumn(name="command_history_status_id", referencedColumnName="id", nullable=false)
     */
    protected $status;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="commandHistory")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    protected $createdBy;

    /**
     * NewsFlagModel constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->createdBy = auth()->user();
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
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
     * @return CommandHistoryStatus
     */
    public function getStatus(): CommandHistoryStatus
    {
        return $this->status;
    }

    /**
     * @param CommandHistoryStatus $status
     * @return CommandHistoryModel
     */
    public function setStatus(CommandHistoryStatus $status): CommandHistoryModel
    {
        $this->status = $status;
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
     *
     * @return CommandHistoryModel
     */
    public function setCreatedBy(User $createdBy): CommandHistoryModel
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
