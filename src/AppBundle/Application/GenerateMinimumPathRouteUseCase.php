<?php

namespace AppBundle\Application;

use AppBundle\Domain\BranchBound;
use AppBundle\Domain\ClientsOutput;
use AppBundle\Domain\Entity\ClientsRepository;
use Exception;


final class GenerateMinimumPathRouteUseCase
{

    private $clientsRepository;
    private $clientsOutput;

    public function __construct(ClientsRepository $clientsRepository, ClientsOutput $clientsOutput)
    {
        $this->clientsRepository = $clientsRepository;
        $this->clientsOutput = $clientsOutput;
    }


    public function __invoke()
    {
        try {
            $locations = $this->clientsRepository->load();
            $tsp = BranchBound::createTreeInstance($locations);
            $clients = $tsp->minimumPathRoute();
            $this->clientsOutput->output($clients);
        } catch (Exception $e) {
            echo $e;
            exit;
        }
    }

}