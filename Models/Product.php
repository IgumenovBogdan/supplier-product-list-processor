<?php
class Product {
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function getUnique()
    {
        $combination = [];
        foreach ($this->data as $property => $value) {
            $combination[] = "$property: $value";
        }
        return implode(", ", $combination);
    }
}