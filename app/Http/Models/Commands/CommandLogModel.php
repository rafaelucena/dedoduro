<?php

namespace App\Http\Models\Commands;

use App\Http\Models\User;
use App\Http\Models\Commands\CommandLogStatusModel as CommandLogStatus;
use App\Http\Models\Commands\CommandModel as Command;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="command_log")
 * @ORM\HasLifecycleCallbacks()
 */
class CommandLogModel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255,nullable=false)
     */
    public $executed;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    public $duration;

    /**
     * @var float
     * @ORM\Column(type="float", nullable=true)
     */
    public $usageCpu;

    /**
     * @var
     * @ORM\Column(type="float", nullable=true)
     */
    public $usageMemory;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    public $startedAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $finishedAt;

    /**
     * @var CommandLogStatus
     * @ORM\ManyToOne(targetEntity="CommandLogStatusModel", inversedBy="commandLog")
     * @ORM\JoinColumn(name="status_id", referencedColumnName="id", nullable=false)
     */
    protected $status;

    /**
     * @var Command
     * @ORM\ManyToOne(targetEntity="CommandModel", inversedBy="commandLog")
     * @ORM\JoinColumn(name="command_id", referencedColumnName="id", nullable=false)
     */
    protected $command;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Http\Models\User", inversedBy="commandLog")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    protected $createdBy;

    /**
     * NewsFlagModel constructor.
     */
    public function __construct()
    {
        $this->startedAt = new DateTime();
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
        }
    }

    /**
     * @return CommandLogStatus
     */
    public function getStatus(): CommandLogStatus
    {
        return $this->status;
    }

    /**
     * @param CommandLogStatus $status
     * @return CommandLogModel
     */
    public function setStatus(CommandLogStatus $status): CommandLogModel
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return CommandModel
     */
    public function getCommand(): CommandModel
    {
        return $this->command;
    }

    /**
     * @param CommandModel $command
     */
    public function setCommand(CommandModel $command): void
    {
        $this->command = $command;
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
     * @return CommandLogModel
     */
    public function setCreatedBy(User $createdBy): CommandLogModel
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
