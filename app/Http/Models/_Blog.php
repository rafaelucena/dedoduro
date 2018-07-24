<?php

namespace App\Http\Models;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="_blog")
 */
class _Blog
{
//`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//`title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
//`slug` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
//`image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
//`excerpt` text COLLATE utf8mb4_unicode_ci NOT NULL,
//`description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
//`views` int(10) unsigned NOT NULL DEFAULT '1',
//`user_id` int(10) unsigned NOT NULL,
//`is_active` tinyint(3) unsigned NOT NULL DEFAULT '0',
//`allow_comments` tinyint(3) unsigned NOT NULL DEFAULT '1',
//`created_at` timestamp NULL DEFAULT NULL,
//`updated_at` timestamp NULL DEFAULT NULL,
//`deleted_at` timestamp NULL DEFAULT NULL,
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $image;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $excerpt;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $description;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $views;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $isActive;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $allowComments;

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
}
