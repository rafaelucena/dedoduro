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
//$table->increments('id');
//$table->integer('blog_id')->unsigned()->nullable(false);
//$table->foreign('blog_id')->references('id')->on('blogs');
//$table->integer('category_id')->unsigned()->nullable(false);
//$table->foreign('category_id')->references('id')->on('categories');
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
