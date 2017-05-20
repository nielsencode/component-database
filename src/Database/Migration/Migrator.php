<?php
namespace Components\Database\Migration;

class Migrator
{
    public function __construct(
        MigrationRepository $migrationRepository,
        MigrationFactory $migrationFactory,
        $migrationsPath
    ) {
        $this->migrationRepository = $migrationRepository;

        $this->migrationFactory = $migrationFactory;

        $this->migrationsPath = $migrationsPath;
    }

    public function createTable()
    {
        $this->migrationRepository->createTable();
    }

    public function dropTable()
    {
        $this->migrationRepository->dropTable();
    }

    public function getOutstandingMigrationFiles()
    {
        $migrationFiles = [];

        foreach (glob("{$this->migrationsPath}/*") as $file) {
            $migrationFiles[] = pathinfo($file,PATHINFO_BASENAME);
        }

        if (empty($migrationFiles)) {
            return false;
        }

        $lastMigration = $this->migrationRepository->getLastMigration();

        if (empty($lastMigration)) {
            $outstandingMigrations = $migrationFiles;
        } else {
            $key = array_search($lastMigration['filename'],$migrationFiles)+1;

            $outstandingMigrations = array_slice($migrationFiles,$key);
        }

        return $outstandingMigrations;
    }

    public function migrate()
    {
        if (!$outstandingMigrations = $this->getOutstandingMigrationFiles()) {
            return false;
        }

        $successfulMigrations = [];

        foreach ($outstandingMigrations as $file) {
            $path = "{$this->migrationsPath}/$file";

            $migration = $this->migrationFactory->makeFromFile($path);

            $migration->up();

            $this->migrationRepository->add(['filename' => $file]);

            $successfulMigrations[] = pathinfo($file,PATHINFO_FILENAME);
        }

        return $successfulMigrations;
    }

    public function rollback()
    {
        if (!$lastMigration = $this->migrationRepository->getLastMigration()) {
            return false;
        }

        $path = "{$this->migrationsPath}/{$lastMigration['filename']}";

        $migration = $this->migrationFactory->makeFromFile($path);

        $migration->down();

        $this->migrationRepository->delete($lastMigration['id']);

        return pathinfo($lastMigration['filename'],PATHINFO_FILENAME);
    }
}