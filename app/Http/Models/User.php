<?php

namespace App\Http\Models;

use App\Http\Models\Blog;
use App\Http\Models\Category;
use App\Http\Models\UserRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User extends Authenticatable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    public $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    public $about;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    public $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    public $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    public $confirmationToken;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    public $isActive;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    public $rememberToken;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    public $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Blog", mappedBy="user")
     */
    public $blogs;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="user")
     */
    public $categories;

    /**
     * @ORM\OneToMany(targetEntity="UserRole", mappedBy="user")
     */
    public $userRoles;

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

    /**
     * Check one role
     * @param string $role
     */
    public function hasRole($role)
    {
//        return null !== $this->roles()->where('role', $role)->first();
        return true;
    }
}
