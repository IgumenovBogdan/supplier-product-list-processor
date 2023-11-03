<?php
require_once 'Services/ArgumentService.php';
require_once 'Services/ParserService.php';
require_once 'Models/Product.php';

$arguments = ArgumentService::parseArguments($argv);

$fileFormat = pathinfo($arguments['file'], PATHINFO_EXTENSION);

$parserName = ParserService::getParserName($fileFormat);
$parser = new $parserName();

$productsGenerator = $parser->parseFile($arguments['file'], $arguments['unique-combinations']);
$parser->outputProducts($productsGenerator);