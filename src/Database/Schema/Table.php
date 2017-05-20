<?php
namespace Components\Database\Schema;

require_once __DIR__.'/Field.php';

class Table
{
    public $name;

    public $primaryKey;

    public $fields = [];

    public $rows = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function field($name,$callback)
    {
        $field = new Field($name);

        $callback($field);

        $this->fields[$name] = $field;
    }

    public function primaryKey($name)
    {
        $this->primaryKey = $name;
    }
}