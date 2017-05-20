<?php

use Components\Database\Drivers\File;
use Components\Database\Migration\MigrationRepository;
use Components\Database\Migration\MigrationFactory;
use Components\Database\Migration\Migrator;
use Components\Database\Migration\MigrationCreator;

require_once __DIR__.'/../vendor/autoload.php';

class MigrationTest extends PHPUnit\Framework\TestCase
{
    /**
     * @var Migrator
     */
    protected $migrator;

    /**
     * @var MigrationCreator
     */
    protected $migrationCreator;

    protected $databasePath = __DIR__.'/database';

    public function setUp()
    {
        date_default_timezone_set("America/Los_Angeles");

        $database = new File($this->databasePath);

        $migrationRepository = new MigrationRepository($database);

        $migrationFactory = new MigrationFactory($database);

        $this->migrator = new Migrator(
            $migrationRepository,
            $migrationFactory,
            __DIR__.'/migrations'
        );

        $this->migrationCreator = new MigrationCreator(__DIR__.'/migrations');
    }

    public function testCreateTable()
    {
        $this->migrator->createTable();

        $expected = "{$this->databasePath}/migrations.sample.json";

        $actual = "{$this->databasePath}/migrations.json";

        $this->assertFileEquals($expected,$actual);
    }

    /**
     * @depends testCreateTable
     */
    public function testDropTable()
    {
        $this->migrator->dropTable();

        $this->assertTrue(!file_exists("{$this->databasePath}/migrations.json"));
    }

    public function testCreateMigration()
    {
        $file = $this->migrationCreator->create('create-users-table');

        $path = __DIR__.'/migrations/'.$file;

        $this->assertFileExists($path);

        unlink($path);
    }

    public function testMigrate()
    {
        $this->migrator->migrate();

        $this->assertFileExists("{$this->databasePath}/users.json");
    }
}