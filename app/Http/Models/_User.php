<?php

namespace App\Http\Models;

use App\Http\Models\_Blog;
use App\Http\Models\_Category;
use App\Http\Models\_UserRole;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class _User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $about;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $confirmationToken;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $isActive;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    protected $rememberToken;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="_Blog", mappedBy="user")
     */
    protected $blogs;

    /**
     * @ORM\OneToMany(targetEntity="_Category", mappedBy="user")
     */
    protected $categories;

    /**
     * @ORM\OneToMany(targetEntity="_UserRole", mappedBy="user")
     */
    protected $userRoles;
}
