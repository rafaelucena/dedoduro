<?php

namespace App\Http\Models;

use App\Http\Models\BlogCategory;
use App\Http\Models\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    public $name;

    /**
     * @ORM\Column(type="string", length=127, nullable=false)
     */
    public $slug;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    public $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="categories")
     */
    public $user;

    /**
     * @ORM\OneToMany(targetEntity="BlogCategory", mappedBy="category")
     */
    public $blogsCategory;

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
