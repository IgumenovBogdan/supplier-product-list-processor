<?php

class ParserService
{
    public static function getParserName(string $fileFormat): string
    {
        // parsing files of the separated values type differs only in the delimiter, so we need to separate this type from xml, json etc. implementations
        $parserName = in_array($fileFormat, ['csv', 'tsv', 'dsv', 'ssv', 'psv']) ? 'SeparatedValuesParser' : ucfirst($fileFormat) . 'Parser';
        $parserFileName = 'Parsers/' . $parserName . '.php';

        if (file_exists($parserFileName)) {
            require_once $parserFileName;

            return $parserName;
        }

        die("Error: Unsupported file format ('$fileFormat'). \n");
    }
}