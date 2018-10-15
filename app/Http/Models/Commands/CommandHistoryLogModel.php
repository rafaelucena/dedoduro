<?php

namespace App\Http\Models\Commands;

use App\Http\Models\User;
use App\Http\Models\Commands\CommandHistoryLogTypeModel as CommandHistoryLogType;
use App\Http\Models\Commands\CommandHistoryModel as CommandHistory;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="command_history_log")
 * @ORM\HasLifecycleCallbacks()
 */
class CommandHistoryLogModel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=511, nullable=false)
     */
    public $subject;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    public $description;

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
     * @var CommandHistory
     * @ORM\ManyToOne(targetEntity="CommandHistoryModel", inversedBy="commandHistoryLogs")
     * @ORM\JoinColumn(name="command_history_id", referencedColumnName="id", nullable=false)
     */
    protected $commandHistory;

    /**
     * @var CommandHistoryLogType
     * @ORM\ManyToOne(targetEntity="CommandHistoryLogTypeModel", inversedBy="commandHistoryLogs")
     * @ORM\JoinColumn(name="command_history_log_type_id", referencedColumnName="id", nullable=false)
     */
    protected $commandHistoryLogType;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Http\Models\User", inversedBy="commandHistory")
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
     * @return CommandHistory
     */
    public function getCommandHistory(): CommandHistory
    {
        return $this->commandHistory;
    }

    /**
     * @param CommandHistory $commandHistory
     *
     * @return CommandHistoryLogModel
     */
    public function setCommandHistory(CommandHistory $commandHistory): CommandHistoryLogModel
    {
        $this->commandHistory = $commandHistory;

        return $this;
    }

    /**
     * @return CommandHistoryLogType
     */
    public function getCommandHistoryLogType(): CommandHistoryLogType
    {
        return $this->commandHistoryLogType;
    }

    /**
     * @param CommandHistoryLogType $commandHistoryLogType
     *
     * @return CommandHistoryLogModel
     */
    public function setCommandHistoryLogType(CommandHistoryLogType $commandHistoryLogType): CommandHistoryLogModel
    {
        $this->commandHistoryLogType = $commandHistoryLogType;

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
     * @return CommandHistoryLogModel
     */
    public function setCreatedBy(User $createdBy): CommandHistoryLogModel
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
