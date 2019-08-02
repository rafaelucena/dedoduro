<?php

namespace App\Http\Models\Commands;

use App\Http\Models\User;
use App\Http\Models\Commands\CommandTypeModel as CommandType;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="command")
 * @ORM\HasLifecycleCallbacks()
 */
class CommandModel
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
     * @var CommandType
     * @ORM\ManyToOne(targetEntity="CommandTypeModel", inversedBy="commands")
     * @ORM\JoinColumn(name="command_type_id", referencedColumnName="id", nullable=false)
     */
    protected $type;

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
     * @return CommandModel
     */
    public function setCreatedBy(User $createdBy): CommandModel
    {
        $this->createdBy = $createdBy;

        return $this;
    }
}
