<?php

namespace App\Http\Models;

use App\Http\Models\User;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Illuminate\Support\Str;
use LaravelDoctrine\ORM\Contracts\UrlRoutable;

/**
 * @ORM\Entity()
 * @ORM\Table(name="persona")
 * @ORM\HasLifecycleCallbacks()
 */
class Persona implements UrlRoutable
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
    public $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    public $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    public $shortName;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    public $slug;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $image;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    public $description;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    public $views;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    public $isActive;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    public $isDeleted;

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
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="personas")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     */
    public $createdBy;

    /**
     * @var ArrayCollection|Politician[]
     * @ORM\OneToMany(targetEntity="Politician", mappedBy="persona")
     */
    public $politicians;

    /**
     * @var ArrayCollection|PersonaSlug[]
     * @ORM\OneToMany(targetEntity="PersonaSlug", mappedBy="persona")
     */
    public $personaSlugs;

    public function __construct()
    {
        //@TODO
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist()
    {
        $this->slug = Str::slug($this->shortName);
        $this->createdBy = auth()->user();
        $this->createdAt = new DateTime();
        $this->isActive = (int) true;
        $this->isDeleted = (int) false;
    }

    /**
     * @param PreUpdateEventArgs $eventArgs
     * @ORM\PreUpdate()
     */
    public function onPreUpdate(PreUpdateEventArgs $eventArgs)
    {
        if (!empty($eventArgs->getEntityChangeSet())) {
            $this->updatedAt = new DateTime();
        }
    }

    /**
     * @param bool $all
     * @return ArrayCollection|Slug[]
     */
    public function getSlugs(bool $all = false)
    {
        $criteria = Criteria::create();
        if ($all !== true) {
            $criteria->where(Criteria::expr()->eq('isActive', true));
        }
        return $this->personaSlugs->matching($criteria);
    }

    /**
     *
     * @return string
     */
    public static function getRouteKeyName(): string
    {
        return 'slug';
    }
}
