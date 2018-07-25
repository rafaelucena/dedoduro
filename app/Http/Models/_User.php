<?php

namespace App\Http\Models;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class _User
{
//`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//`name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
//`about` text COLLATE utf8mb4_unicode_ci,
//`email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
//`password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
//`confirmation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
//`is_active` tinyint(4) DEFAULT '0',
//`remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
//`created_at` timestamp NULL DEFAULT NULL,
//`updated_at` timestamp NULL DEFAULT NULL,
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

    protected $blogs;

    protected $categories;

    protected $roles;
}
