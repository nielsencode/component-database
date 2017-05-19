<?php

use Components\Database\Drivers\File;

require_once __DIR__.'/../vendor/autoload.php';

class DatabaseTest extends PHPUnit\Framework\TestCase
{
    protected $database;

    public function setUp()
    {
        $this->database = new File(__DIR__.'/database');
    }

    public function testCreateTable()
    {
        $this->database->schema('users')->create(function ($table) {

            $table->field('id',function ($field) {
                $field->integer(10)->increments();
            });

            $table->field('name',function ($field) {
                $field->string()->unique();
            });

            $table->field('password',function($field) {
                $field->string();
            });

            $table->field('date_created',function ($field) {
                $field->timestamp();
            });

            $table->field('date_updated',function ($field) {
                $field->timestamp();
            });

        });

        $this->assertFileExists($this->database->path.'/users.json');

        $expected = $this->database->path.'/users.sample.json';

        $actual = $this->database->path.'/users.json';

        $this->assertFileEquals($expected,$actual);
    }

    /**
     * @depends testCreateTable
     */
    public function testDropTable()
    {
        $this->database->schema('users')->drop();

        $this->assertTrue(!file_exists($this->database->path.'/users.json'));
    }
}