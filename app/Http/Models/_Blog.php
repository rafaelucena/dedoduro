<?php

namespace App\Http\Models;

use App\Http\Models\_BlogCategory;
use App\Http\Models\_Comment;
use App\Http\Models\_User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog")
 */
class _Blog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    protected $slug;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $image;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    protected $excerpt;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     */
    protected $description;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $views;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $isActive;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $allowComments;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @var _User
     * @ORM\ManyToOne(targetEntity="_User", inversedBy="blogs")
     */
    protected $user;

    /**
     * @var ArrayCollection|_Comment[]
     * @ORM\OneToMany(targetEntity="_Comment", mappedBy="blog")
     */
    protected $comments;

    /**
     * @var ArrayCollection|_BlogCategory[]
     * @ORM\OneToMany(targetEntity="_BlogCategory", mappedBy="blog")
     */
    protected $blogCategories;

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
