<?php
namespace Components\Database\Migration;

use Components\Database\Database;
use function Components\Database\studlyCaps;

require_once __DIR__.'/../Database.php';
require_once __DIR__.'/../../functions.php';

class MigrationFactory
{
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function makeFromFile($path)
    {
        preg_match(
            '/[^_]+_[^_]+_([^\.]+)/',
            pathinfo($path,PATHINFO_FILENAME),
            $matches
        );

        $className = studlyCaps($matches[1]);

        require_once $path;

        return new $className($this->database);
    }
}