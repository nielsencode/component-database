<?php
namespace Components\Database\Schema;

class Table extends FieldType
{
    public $name;

    public $fields = [];

    public $rows = [];

    public function __construct($name)
    {
        parent::__construct();

        $this->name = $name;
    }

    public function field($name,$callback)
    {
        $field = new Field($name);

        $callback($field);

        $this->fields[$name] = $field;
    }
}