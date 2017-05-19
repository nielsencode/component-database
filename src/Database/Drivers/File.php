<?php
namespace Components\Database\Drivers;

use Components\Database\Database;
use Components\Database\Schema\Builder;

class File extends Database
{
    public $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    protected function getTablePath($name)
    {
        return "{$this->path}/$name.json";
    }

    public function createSchema(Builder $builder)
    {
        $tablePath = $this->getTablePath($builder->table->name);

        if (file_exists($tablePath)) {
            throw new \Exception(
                "Table \"{$builder->table->name}\" already exists."
            );
        }

        $table = json_encode($builder->table,JSON_PRETTY_PRINT);

        file_put_contents($tablePath,$table);

        return true;
    }

    public function dropSchema(Builder $builder)
    {
        $tablePath = $this->getTablePath($builder->table->name);

        if (!file_exists($tablePath)) {
            throw new \Exception(
                "Table \"{$builder->table->name}\" does not exist."
            );
        }

        unlink($tablePath);

        return true;
    }
}