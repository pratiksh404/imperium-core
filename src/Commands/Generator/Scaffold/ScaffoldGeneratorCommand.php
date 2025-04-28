<?php

namespace Pratiksh\Imperium\Commands\Generator\Scaffold;

use Illuminate\Console\Command;
use Pratiksh\Imperium\Services\Generator\Scaffold\ResourcefulScaffoldGenerator;
use Pratiksh\Imperium\Traits\Console\NeedsModel;

class ScaffoldGeneratorCommand extends Command
{
    use NeedsModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:scaffold {--custom : Custom form control}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate a new resource scaffold';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $selected_model = $this->getModelFromConsole();

        $model = $selected_model->model;
        $namespace = $selected_model->namespace;

        $generator = new ResourcefulScaffoldGenerator($model, $namespace);

        $generator->generate();
    }
}
