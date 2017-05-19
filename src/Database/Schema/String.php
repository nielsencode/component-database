<?php
namespace Components\Database\Schema;

class String extends FieldType
{
    public $unique = false;

    public function unique()
    {
        $this->unique = true;
    }
}