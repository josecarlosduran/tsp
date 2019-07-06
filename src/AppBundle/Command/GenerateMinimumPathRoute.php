<?php


namespace AppBundle\Command;

use AppBundle\Application\GenerateMinimumPathRouteUseCase;
use AppBundle\Infrastucture\ConsoleClientsOutput;
use AppBundle\Infrastucture\FileClientsRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateMinimumPathRoute extends Command
{

    protected static $defaultName = 'app:generate-path';

    protected function configure()
    {
        $this->setDescription('Generate minimum path route using a file in actual directory')
            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Generate minimum path route using a file in actual directory, this file must be named as clientes.txt, the info is printed in console');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientsRepository = new FileClientsRepository();
        $clientsOutput = new ConsoleClientsOutput();
        $generateMinimumPathRouteUseCase = new GenerateMinimumPathRouteUseCase($clientsRepository, $clientsOutput);
        $generateMinimumPathRouteUseCase();

    }

}