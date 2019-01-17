<?php

namespace App\Http\Models;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * @ORM\Entity()
 * @ORM\Table(name="news_log")
 * @ORM\HasLifecycleCallbacks()
 */
class NewsLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    public $id;

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
     * @var NewsLogStatus
     * @ORM\ManyToOne(targetEntity="NewsLogStatus", inversedBy="NewsLogs")
     */
    protected $newsLogStatus;

    /**
     * @var News
     * @ORM\ManyToOne(targetEntity="News", inversedBy="NewsLogs")
     */
    protected $news;
}
