<?php

namespace App\Http\Models;

use App\Http\Models\_BlogCategory;
use App\Http\Models\_Comment;
use App\Http\Models\_User;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog")
 */
class _Blog
{
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

    /**
     * @ORM\ManyToOne(targetEntity="_User", inversedBy="blogs")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="_Comment", mappedBy="blog")
     */
    protected $comments;

    /**
     * @ORM\OneToMany(targetEntity="_BlogCategory", mappedBy="blog")
     */
    protected $blogCategories;
}
