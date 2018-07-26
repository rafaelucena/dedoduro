<?php

namespace App\Http\Models;

use App\Http\Models\_User;
use App\Http\Models\_Role;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_role")
 */
class _UserRole
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @ORM\ManyToOne(targetEntity="_User", inversedBy="userRoles")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="_Role", inversedBy="usersRole")
     */
    protected $role;
}
