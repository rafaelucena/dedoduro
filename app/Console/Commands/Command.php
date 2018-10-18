<?php

namespace App\Console\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface as Input;

class Command extends BaseCommand
{
    private $logType = [
        'success',
        'error',
        'info',
    ];

    private $status = [
        'pending',
        'started',
        'halted',
        'finished',
    ];

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    protected $signature = 'base_command';

    protected $hidden = true;

    protected $log;

    /**
     * Command constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }

    protected function startLog(Input $input)
    {
        $user = $this->em->getRepository(\App\Http\Models\User::class)->findOneBy([
            'name' => 'robocop_x9',
        ]);
        $status = $this->em->getRepository(\App\Http\Models\Commands\CommandHistoryStatusModel::class)->findOneBy([
            'name' => 'started',
        ]);
        $command = $this->em->getRepository(\App\Http\Models\Commands\CommandModel::class)->find(1);

        $commandHistory = new \App\Http\Models\Commands\CommandHistoryModel();
        $commandHistory->executed = (string) $input;
        $commandHistory->setCommand($command);
        $commandHistory->setCreatedBy($user);
        $commandHistory->setStatus($status);

        $this->em->persist($commandHistory);
        $this->em->flush();

        $this->log = $commandHistory;
    }

    protected function endLog(array $messages)
    {
        $status = $this->em->getRepository(\App\Http\Models\Commands\CommandHistoryStatusModel::class)->findOneBy([
            'name' => 'finished',
        ]);

        $this->log->setStatus($status);
        $this->log->finishedAt = new \DateTime();
        $this->log->duration = ($this->log->finishedAt->getTimestamp() - $this->log->startedAt->getTimestamp());
        $this->log->usageCpu = memory_usage();
        $this->log->usageMemory = cpu_usage();


        $this->em->persist($this->log);
        $this->em->flush();

        die;
    }
}
