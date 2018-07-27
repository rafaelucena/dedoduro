<?php

namespace App\Http\Models;

use App\Http\Models\_User;
use App\Http\Models\_Role;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user_role")
 */
class _UserRole
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    public $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity="_User", inversedBy="userRoles")
     */
    public $user;

    /**
     * @ORM\ManyToOne(targetEntity="_Role", inversedBy="usersRole")
     */
    public $role;

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->createdAt = time();
    }

    /**
     * @param PreUpdateEventArgs $eventArgs
     * @ORM\PreUpdate()
     */
    public function onPreUpdate(PreUpdateEventArgs $eventArgs)
    {
        if (!empty($eventArgs->getEntityChangeSet())) {
            $this->updatedAt = time();
        }
    }
}
