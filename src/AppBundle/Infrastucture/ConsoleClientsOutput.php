<?php


namespace AppBundle\Infrastucture;

use AppBundle\Domain\ClientsOutput;

final class ConsoleClientsOutput implements ClientsOutput
{

    public function output(array $clients)
    {
        foreach ($clients as $client) {
            echo($client . "\n");
        }
    }

}