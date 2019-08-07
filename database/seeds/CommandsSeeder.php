<?php

use Illuminate\Database\Seeder;
use Doctrine\ORM\EntityManagerInterface;
use App\Http\Models\Commands\CommandModel;
use App\Http\Models\User;
use App\Http\Models\Commands\CommandTypeModel;
use App\Http\Models\Commands\CommandOptionModel;

class CommandsSeeder extends Seeder
{
    /** EntityManagerInterface $em */
    protected $em;

    /** @var array */
    private $commandData = [];

    /** @var User */
    private $creator;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->creator = $this->em->getRepository(User::class)->find(1);
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setCommandTypes();
        $this->setCommands();
        $this->setCommandOptions();
        $this->em->flush();
    }

    private function setCommandTypes()
    {
        if ($this->em->getRepository(CommandModel::class)->findAll()) {
            return;
        }

        $commandTypeExplorer = new CommandTypeModel();
        $commandTypeExplorer->createdAt = new \DateTime();
        $commandTypeExplorer->setCreatedBy($this->creator);
        $commandTypeExplorer->name = 'explorer';
        $this->em->persist($commandTypeExplorer);
        $this->commandData['type:explorer'] = $commandTypeExplorer;
    }

    private function setCommands()
    {
        if ($this->em->getRepository(CommandModel::class)->findAll()) {
            return;
        }

        $commandNewsCollect = new CommandModel();
        $commandNewsCollect->name = 'news:collect';
        $commandNewsCollect->createdAt = new \DateTime();
        $commandNewsCollect->setType($this->commandData['type:explorer']);
        $commandNewsCollect->setCreatedBy($this->creator);
        $this->em->persist($commandNewsCollect);
        $this->commandData['command:news:collect'] = $commandNewsCollect;

        $commandNewsCheck = new CommandModel();
        $commandNewsCheck->name = 'news:check';
        $commandNewsCheck->createdAt = new \DateTime();
        $commandNewsCheck->setType($this->commandData['type:explorer']);
        $commandNewsCheck->setCreatedBy($this->creator);
        $this->em->persist($commandNewsCheck);
        $this->commandData['command:news:check'] = $commandNewsCheck;
    }

    private function setCommandOptions()
    {
        if ($this->em->getRepository(CommandOptionModel::class)->findAll()) {
            return;
        }

        $commandOptionPriority = new CommandOptionModel();
        $commandOptionPriority->name = 'priority';
        $commandOptionPriority->setCreatedBy($this->creator);
        $commandOptionPriority->setCommand($this->commandData['command:news:collect']);
        $this->em->persist($commandOptionPriority);
    }
}
