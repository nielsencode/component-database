<?php
namespace Components\Database\Query;

use Components\Database\Database;

class Builder
{
    public function __construct(Database $database,$table)
    {
        $this->database = $database;

        $this->table = $table;
    }

    public function orderBy()
    {

    }
}