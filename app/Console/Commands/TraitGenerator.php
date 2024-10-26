<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class TraitGenerator extends Command
{
    protected $signature = 'make:trait {name}';
    protected $description = 'Create a new Trait';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $filesystem = new Filesystem();
        $traitName = Str::studly($name);
        $traitPath = app_path("Traits/{$traitName}.php");

        if ($filesystem->exists($traitPath)) {
            $this->error("Trait {$traitName} already exists!");
            return;
        }

        $stub = $this->getStub();
        $stub = str_replace('{{traitName}}', $traitName, $stub);
        $filesystem->ensureDirectoryExists(app_path('Traits'));
        $filesystem->put($traitPath, $stub);

        $this->info("Trait {$traitName} created successfully.");
    }

    protected function getStub()
    {
        return <<<'STUB'
        <?php

        namespace App\Traits;

        trait {{traitName}}
        {
            //
        }
        STUB;
    }
}
