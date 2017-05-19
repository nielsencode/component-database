<?php
namespace Components\Database\Schema;

abstract class FieldType
{
    public $name;

    public function __construct()
    {
        $this->name = strtolower((new \ReflectionClass($this))->getShortName());
    }
}