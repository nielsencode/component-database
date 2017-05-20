<?php
namespace Components\Database\Schema;

use Components\Database\Database;

require_once __DIR__.'/../Database.php';
require_once __DIR__.'/Table.php';

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