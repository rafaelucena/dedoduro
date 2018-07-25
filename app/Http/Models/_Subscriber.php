<?php

namespace App\Http\Models;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscriber")
 */
class _Subscriber
{
//`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//`email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
//`confirmation_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
//`is_active` tinyint(3) unsigned NOT NULL DEFAULT '0',
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
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $confirmationToken;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $isActive;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updatedAt;
}
