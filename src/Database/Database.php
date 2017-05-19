<?php
namespace Components\Database;

use Components\Database\Schema\Builder;

abstract class Database
{
    public function schema($name)
    {
        return new Builder($this,$name);
    }

    abstract public function createSchema(Builder $builder);

    abstract public function dropSchema(Builder $builder);
}