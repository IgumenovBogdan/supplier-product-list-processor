<?php

interface IParser
{
    public function parseFile(string $productsFilePath, string $combinationsFilePath);

    public function outputProducts(Generator $products);
}