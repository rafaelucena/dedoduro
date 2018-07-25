<?php

namespace App\Http\Models;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class _Category
{
//`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//`name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
//`slug` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
//`user_id` int(10) unsigned NOT NULL,
//`created_at` timestamp NULL DEFAULT NULL,
//`updated_at` timestamp NULL DEFAULT NULL,
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    protected $slug;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updatedAt;

    protected $user;

    protected $blogs;
}
