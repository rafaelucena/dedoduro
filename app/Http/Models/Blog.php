<?php

namespace App\Http\Models;

use App\Http\Models\BlogCategory;
use App\Http\Models\_Comment;
use App\Http\Models\_User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="blog")
 */
class Blog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    public $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    public $slug;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    public $image;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    public $excerpt;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    public $description;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    public $views;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    public $isActive;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    public $allowComments;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    public $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updatedAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $deletedAt;

    /**
     * @var _User
     * @ORM\ManyToOne(targetEntity="_User", inversedBy="blogs")
     */
    public $user;

    /**
     * @var ArrayCollection|_Comment[]
     * @ORM\OneToMany(targetEntity="_Comment", mappedBy="blog")
     */
    public $comments;

    /**
     * @var ArrayCollection|BlogCategory[]
     * @ORM\OneToMany(targetEntity="BlogCategory", mappedBy="blog")
     */
    public $blogCategories;

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->createdAt = time();
    }

    /**
     * @param PreUpdateEventArgs $eventArgs
     * @ORM\PreUpdate()
     */
    public function onPreUpdate(PreUpdateEventArgs $eventArgs)
    {
        if (!empty($eventArgs->getEntityChangeSet())) {
            $this->updatedAt = time();
        }
    }
}
