<?php

namespace App\Http\Models;

use App\Http\Models\Blog;
use App\Http\Models\_Category;
use App\Http\Models\_UserRole;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class _User
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
     * @ORM\OneToMany(targetEntity="_Category", mappedBy="user")
     */
    public $categories;

    /**
     * @ORM\OneToMany(targetEntity="_UserRole", mappedBy="user")
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
}
