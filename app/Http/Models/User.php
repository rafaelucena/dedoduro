<?php

namespace App\Http\Models;

use App\Http\Models\Blog;
use App\Http\Models\Category;
use App\Http\Models\UserRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User implements
    AuthenticatableContract/*,
    AuthorizableContract,
    CanResetPasswordContract*/
{
    /**
     * @var integer
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
     * @var string
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
     * @var string
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
     * @return int
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * @param string $rememberToken
     *
     * @return $this
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'rememberToken';
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
