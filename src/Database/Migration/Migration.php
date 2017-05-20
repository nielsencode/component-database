<?php
namespace Components\Database\Migration;

use Components\Database\Database;

require_once __DIR__.'/../Database.php';

abstract class Migration
{
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    abstract public function up();

    abstract public function down();
}