<?php

use Illuminate\Database\Seeder;
use Doctrine\ORM\EntityManagerInterface;
use App\Http\Models\Commands\CommandModel;
use App\Http\Models\User;
use App\Http\Models\Commands\CommandTypeModel;

class CommandSeeder extends Seeder
{
    /** EntityManagerInterface $em */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
        $commandType = new CommandTypeModel();
        $commandType->createdAt = new \DateTime();
        $commandType->setCreatedBy($this->em->getRepository(User::class)->find(1));
        $commandType->name = 'explorer';
        
        $this->em->persist($commandType);
        $this->em->flush();
    }

    private function setCommands()
    {
        $command = new CommandModel();
        $command->name = 'news:command';
        $command->createdAt = new \DateTime();
        $command->setType($this->em->getRepository(CommandTypeModel::class)->findBy(['name' => 'explorer']));
        
        $this->em->persist($command);
        $this->em->flush($command);
    }
}
