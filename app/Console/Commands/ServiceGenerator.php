<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ServiceGenerator extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class extending BaseService';

    public function handle()
    {
        $name = $this->argument('name');
        $this->createService($name);
    }

    protected function createService($name)
    {
        $serviceDir = app_path('Services');
        $servicePath = "{$serviceDir}/{$name}.php";

        if (!File::isDirectory($serviceDir)) {
            File::makeDirectory($serviceDir, 0755, true);
            $this->info('Services directory created successfully.');
        }

        $baseServicePath = "{$serviceDir}/BaseService.php";
        if (!File::exists($baseServicePath)) {
            $this->createBaseService();
        }

        if (File::exists($servicePath)) {
            $this->error("Service {$name} already exists!");
            return;
        }

        $stub = File::get(base_path('stubs/service.stub'));
        $contents = str_replace('{{name}}', $name, $stub);

        File::put($servicePath, $contents);

        $this->info("Service {$name} created successfully.");
    }

    protected function createBaseService()
    {
        $baseServiceContent = <<<'EOD'
                                    <?php

                                    namespace App\Services;

                                    use Illuminate\Http\JsonResponse;
                                    use App\Traits\HttpResponse;

                                    class BaseService
                                    {
                                        use HttpResponse;
                                    }
        EOD;

        File::put(app_path('Services/BaseService.php'), $baseServiceContent);
        $this->info('BaseService created successfully.');
    }
}
