<?php

namespace App\Http\Models;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="setting")
 */
class _Setting
{
//`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
//`setting_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
//`setting_value` text COLLATE utf8mb4_unicode_ci NOT NULL,
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
    protected $settingName;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $settingValue;

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
}
