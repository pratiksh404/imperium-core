<?php

namespace Pratiksh\Imperium\Commands\Generator\Scaffold;

use Illuminate\Console\Command;
use Pratiksh\Imperium\Services\Generator\Scaffold\ImperiumResourceGenerator;
use Pratiksh\Imperium\Traits\Console\NeedsModel;

use function Laravel\Prompts\info;

class ImperiumResourceGeneratorCommand extends Command
{
    use NeedsModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate imperium resource file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $selected_model = $this->getModelFromConsole();

        $model = $selected_model->model;
        $namespace = $selected_model->namespace;

        $generator = new ImperiumResourceGenerator($model, $namespace);

        $resource = $generator->generate();
        info('Resource created successfully at ['.$resource.']');
    }
}
