<?php

namespace App\Http\Models;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="subscriber")
 */
class _Subscriber
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $confirmationToken;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $isActive;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updatedAt;
}
