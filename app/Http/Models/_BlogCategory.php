<?php

namespace App\Http\Models;

use App\Http\Models\_Blog;
use App\Http\Models\_Category;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="blog_category")
 */
class _BlogCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

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
     * @ORM\ManyToOne(targetEntity="_Blog", inversedBy="blogCategories")
     */
    protected $blog;

    /**
     * @ORM\ManyToOne(targetEntity="_Category", inversedBy="blogsCategory")
     */
    protected $category;
}
