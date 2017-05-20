<?php
namespace Components\Database\Schema;

require_once __DIR__.'/FieldType.php';

class String extends FieldType
{
    public $unique = false;

    public function unique()
    {
        $this->unique = true;
    }
}