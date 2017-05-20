<?php
namespace Components\Database;

use Components\Database\Schema\Builder as SchemaBuilder;
use Components\Database\Query\Builder as QueryBuilder;

require_once __DIR__.'/Schema/Builder.php';

abstract class Database
{
    public function schema($name)
    {
        return new SchemaBuilder($this,$name);
    }

    public function table($name)
    {
        return new QueryBuilder($this,$name);
    }

    abstract public function createSchema(SchemaBuilder $builder);

    abstract public function dropSchema(SchemaBuilder $builder);
}