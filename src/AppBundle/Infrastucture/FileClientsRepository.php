<?php


namespace AppBundle\Infrastucture;

use AppBundle\Domain\Entity\ClientsRepository;
use Exception;

const FILENAME = "clientes.txt";

final class FileClientsRepository implements ClientsRepository
{

    private $source;

    public function __construct()
    {
        $this->source = FILENAME;
    }

    public function load(): array
    {
        $filename = $this->source;
        $file = file_get_contents($filename);
        $this->ensureFileExistGuard($file);
        $fileLines = explode("\n", $file);


        $locationData = [];
        foreach ($fileLines as $a_fileLine) {
            $fileFields = explode(" ", $a_fileLine);
            $this->ensureThreeFieldsGuard($fileFields);
            $fields = $this->composeLine($fileFields);
            $this->ensureCorrectFieldsFormatGuard($fields);

            $a_locationData = [];
            $a_locationData["id"] = $fields[0];
            $a_locationData["latitude"] = $fields[1];
            $a_locationData["longitude"] = $fields[2];
            $locationData[] = $a_locationData;
        }

        return $locationData;
    }

    private function ensureFileExistGuard($file): void
    {

        if (!$file) {
            throw new Exception("File $this->source not exists in actual directory");
        }

    }

    private function ensureThreeFieldsGuard(array $fields): void
    {

        if (!is_array($fields) || count($fields) < 3) {
            throw new Exception("Incorrect format file : All lines in file must have 3 fields $fields[0]");
        }

    }

    private function composeLine($fileFields)
    {
        $line = [];
        $line[2] = array_pop($fileFields);
        $line[1] = array_pop($fileFields);
        $line[0] = implode(" ", $fileFields);
        return $line;
    }

    private function ensureCorrectFieldsFormatGuard(array $fields): void
    {
        //var_dump($fields);die;
        if (!is_string($fields[0]) || !is_numeric($fields[1]) || !is_numeric($fields[2])) {
            throw new Exception("Incorrect format file : Incorrect format in some field");
        }

    }

}