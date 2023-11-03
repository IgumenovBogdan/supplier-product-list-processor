<?php

class Parser
{
    public function validateFiles(array $files): void
    {
        foreach ($files as $filePath) {
            if (!file_exists($filePath)) {
                die("Error: $filePath not found. \n");
            }
        }
    }
}