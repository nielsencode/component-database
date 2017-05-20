<?php
namespace Components\Database\Migration;

use Components\Database\Database;

require_once __DIR__.'/../Database.php';

class MigrationRepository
{
    protected $table = 'migrations';

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function createTable()
    {
        return $this->database->schema($this->table)->create(function($table)
        {
            $table->field('id',function($field)
            {
                $field->integer(10)->increments();
            });

            $table->field('filename',function($field)
            {
               $field->string()->unique();
            });

            $table->primaryKey('id');
        });
    }

    public function dropTable()
    {
        return $this->database->schema($this->table)->drop();
    }

    public function getLastMigration()
    {
        return $this
            ->database
            ->table($this->table)
            ->orderBy('filename')
            ->limit(1)
            ->get()[0];
    }

    public function add($values)
    {
        return $this
            ->database
            ->table($this->table)
            ->insert($values);
    }

    public function delete($id)
    {
        return $this
            ->database
            ->table($this->table)
            ->where('id',$id)
            ->delete();
    }
}