<?php
namespace Components\Database\Schema;

abstract class FieldType
{
    public $name;

    public function __construct()
    {
        $reflection = new \ReflectionClass($this);

        $this->name = strtolower($reflection->getShortName());
    }
}