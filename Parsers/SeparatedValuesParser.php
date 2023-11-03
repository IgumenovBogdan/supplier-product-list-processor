<?php
require_once 'IParser.php';
require_once 'Parser.php';

class SeparatedValuesParser extends Parser implements IParser
{
    private const DELIMITERS = [',', "\t", ';', '|', ':'];

    public function parseFile(string $productsFilePath, string $combinationsFilePath): Generator
    {
        $this->validateFiles([$productsFilePath, $combinationsFilePath]);

        $handle = fopen($productsFilePath, 'r');
        $headers = null;
        $delimiter = null;
        $products = [];

        if ($handle !== false) {
            $firstIteration = true;
            $delimiter = $this->findWorkingDelimiter($handle);
            while (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
                if ($firstIteration) {
                    $headers = $data;
                    $firstIteration = false;
                } else {
                    $productData = array_combine($headers, $data);
                    $products[] = new Product($productData);
                    yield new Product($productData);
                }
            }
            fclose($handle);
        }

        $combinations = $this->getCombinationsValues($combinationsFilePath, $delimiter, $headers);

        $this->countUniqueCombinations($products, $headers, $combinations);
    }

    public function outputProducts(Generator $products): void
    {
        foreach ($products as $product) {
            echo $product->getUnique() . "\n";
        }
        echo "Unique combinations saved to unique_combinations.csv\n";
    }

    private function findWorkingDelimiter($handle): ?string
    {
        $delimiter = null;
        $firstLine = fgets($handle);
        foreach (self::DELIMITERS as $possibleDelimiter) {
            if (strpos($firstLine, $possibleDelimiter) !== false) {
                $delimiter = $possibleDelimiter;
                break;
            }
        }
        rewind($handle);

        if (!$delimiter) {
            die("Error: Delimiter is not support. \n");
        }

        return $delimiter;
    }

    private function countUniqueCombinations(array $products, array $fieldsToCount, array $combinations): void
    {
        $uniqueCombinations = [];

        foreach ($fieldsToCount as $field) {
            $combinationsCount = [];

            foreach ($products as $product) {
                $value = $product->$field;
                if (!isset($combinationsCount[$value])) {
                    $combinationsCount[$value] = 1;
                } else {
                    $combinationsCount[$value]++;
                }
            }

            $uniqueCombinations[$field] = $combinationsCount;
        }

        $this->saveUniqueCombinations($combinations, $uniqueCombinations);
    }

    private function saveUniqueCombinations(array $combinations, array $uniqueCombinations): void
    {
        $uniqueCombinationsFile = 'unique_combinations.csv';
        foreach ($combinations as $field => $combination) {
            file_put_contents($uniqueCombinationsFile, "$field: " . ($uniqueCombinations[$field][$combination] ?? 0) . "\n", FILE_APPEND);
        }
    }

    private function getCombinationsValues(string $filePath, string $delimiter, array $headers): array
    {
        $combinations = [];
        $combinationsHeaders = [];
        $handle = fopen($filePath, 'r');

        if ($handle === false) {
            return [];
        }

        $firstIteration = true;
        while (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
            if ($firstIteration) {
                $combinationsHeaders = $data;
                $firstIteration = false;
            } else {
                if (count($combinationsHeaders) !== count($headers)) {
                    die("Error: Files cannot have different numbers of fields. \n");
                }

                $combinationsData = array_combine($headers, $data);
                $combinations = $combinationsData;
            }
        }
        fclose($handle);

        return $combinations;
    }
}