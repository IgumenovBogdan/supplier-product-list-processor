<?php
class ArgumentService {
    public static function parseArguments($argv)
    {
        $arguments = [];
        for ($i = 1, $iMax = count($argv); $i < $iMax; $i++) {
            $arg = $argv[$i];
            if (strpos($arg, '--') === 0) {
                $parts = explode('=', substr($arg, 2));
                if (count($parts) === 2) {
                    $arguments[$parts[0]] = $parts[1];
                } else {
                    die("Error: Invalid argument: $arg\n");
                }
            }
        }
        if (!isset($arguments['file']) || !isset($arguments['unique-combinations'])) {
            die("Error: Please provide --file and --unique-combinations arguments\n");
        }
        return $arguments;
    }
}