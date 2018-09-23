<?php

namespace App\Console\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command as BaseCommand;

class Command extends BaseCommand
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    protected $signature = 'base_command';

    protected $hidden = true;

    /**
     * Command constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }
}
