<?php

use Illuminate\Database\Seeder;
use Doctrine\ORM\EntityManagerInterface;
use App\Http\Models\Commands\CommandModel;
use App\Http\Models\User;
use App\Http\Models\Commands\CommandTypeModel;

class CommandsSeeder extends Seeder
{
    /** EntityManagerInterface $em */
    protected $em;

    /** @var array */
    private $commandTypes = [];

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
        $this->em->flush();
    }

    private function setCommandTypes()
    {
        $commandTypeExplorer = new CommandTypeModel();
        $commandTypeExplorer->createdAt = new \DateTime();
        $commandTypeExplorer->setCreatedBy($this->creator);
        $commandTypeExplorer->name = 'explorer';
        $this->em->persist($commandTypeExplorer);
        $this->commandTypes['explorer'] = $commandTypeExplorer;
    }

    private function setCommands()
    {
        $commandNewsCollect = new CommandModel();
        $commandNewsCollect->name = 'news:collect';
        $commandNewsCollect->createdAt = new \DateTime();
        $commandNewsCollect->setType($this->commandTypes['explorer']);
        $commandNewsCollect->setCreatedBy($this->creator);
        $this->em->persist($commandNewsCollect);

        $commandNewsCheck = new CommandModel();
        $commandNewsCheck->name = 'news:check';
        $commandNewsCollect->createdAt = new \DateTime();
        $commandNewsCollect->setType($this->commandTypes['explorer']);
        $commandNewsCollect->setCreatedBy($this->creator);
        $this->em->persist($commandNewsCollect);
    }
}
