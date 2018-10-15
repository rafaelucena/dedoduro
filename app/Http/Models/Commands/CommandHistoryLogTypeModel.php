<?php

namespace App\Http\Models\Commands;

use App\Http\Models\User;
use App\Http\Models\Commands\CommandHistoryLogModel as CommandHistoryLog;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="command_history_log_type")
 * @ORM\HasLifecycleCallbacks()
 */
class CommandHistoryLogTypeModel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=63, nullable=false)
     */
    public $name;

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
     * @var CommandHistoryLog[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="CommandHistoryLogModel", mappedBy="commandHistoryLogType")
     */
    protected $commandHistoryLogs;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Http\Models\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    protected $createdBy;

    /**
     * NewsFlagModel constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
            $this->updatedAt = new \DateTime();
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
     * @return CommandHistoryLogTypeModel
     */
    public function setCreatedBy(User $createdBy): CommandHistoryLogTypeModel
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
