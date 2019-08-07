<?php

namespace App\Http\Models\Commands;

use App\Http\Models\User;
use App\Http\Models\Commands\CommandModel as Command;
use App\Http\Models\Commands\CommandLogStatusModel as CommandLogStatus;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="command_option")
 * @ORM\HasLifecycleCallbacks()
 */
class CommandOptionModel
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
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $deletedAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Http\Models\User", inversedBy="commandLog")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    protected $createdBy;

    /**
     * @var Command
     * @ORM\ManyToOne(targetEntity="CommandModel", inversedBy="commandOptions")
     * @ORM\JoinColumn(name="command_id", referencedColumnName="id", nullable=false)
     */
    protected $command;

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
     * @return CommandOptionModel
     */
    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;

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
     *
     * @return CommandOptionModel
     */
    public function setCommand(CommandModel $command): self
    {
        $this->command = $command;

        return $this;
    }
}
