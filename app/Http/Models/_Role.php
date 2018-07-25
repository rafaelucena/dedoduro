<?php

namespace App\Http\Models;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class _Role
{
//`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//`role` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
//`description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    protected $role;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updatedAt;

    protected $users;
}
