<?php
namespace Components\Database\Schema;

class Integer extends FieldType
{
    public $length;

    public $increments = false;

    public function __construct($length)
    {
        parent::__construct();

        $this->length = $length;
    }

    public function increments()
    {
        $this->increments = true;
    }
}