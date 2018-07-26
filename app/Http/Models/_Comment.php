<?php

namespace App\Http\Models;

use App\Http\Models\_Blog;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="comment")
 */
class _Comment
{
//`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//`name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
//`email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
//`body` text COLLATE utf8mb4_unicode_ci NOT NULL,
//`blog_id` int(10) unsigned NOT NULL,
//`is_active` tinyint(3) unsigned NOT NULL DEFAULT '1',
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $body;

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

    /**
     * @ORM\ManyToOne(targetEntity="_Blog", inversedBy="comments")
     */
    protected $blog;
}
