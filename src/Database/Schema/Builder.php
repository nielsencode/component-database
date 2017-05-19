<?php
namespace Components\Database\Schema;

use Components\Database\Database;

class Builder
{
    public $database;

    public $table;

    public function __construct(Database $database,$table)
    {
        $this->database = $database;

        $this->table = new Table($table);
    }

    public function create($callback)
    {
        $callback($this->table);

        return $this->database->createSchema($this);
    }

    public function drop()
    {
        return $this->database->dropSchema($this);
    }
}