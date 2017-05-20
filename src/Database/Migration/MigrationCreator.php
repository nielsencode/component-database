<?php
namespace Components\Database\Migration;

use function Components\Database\snakeCase;
use function Components\Database\studlyCaps;

require_once __DIR__.'/../../functions.php';

class MigrationCreator
{
    public function __construct($migrationsPath)
    {
        $this->migrationsPath = $migrationsPath;
    }

    public function create($name)
    {
        $template = file_get_contents(__DIR__.'/migration-template.txt');

        $replacements = [
            'migration' => Migration::class,
            'class' => studlyCaps($name)
        ];

        $contents = $template;

        foreach ($replacements as $k=>$v) {
            $contents = str_replace("{% $k %}",$v,$contents);
        }

        $filename = date('Y-m-d').'_'.uniqid().'_'.snakeCase($name).'.php';

        file_put_contents($this->migrationsPath.'/'.$filename,$contents);

        return $filename;
    }
}