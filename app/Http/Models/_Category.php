<?php

namespace App\Http\Models;

use App\Http\Models\_BlogCategory;
use App\Http\Models\_User;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class _Category
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

    /**
     * @ORM\ManyToOne(targetEntity="_User", inversedBy="categories")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="_BlogCategory", mappedBy="category")
     */
    protected $blogsCategory;
}
