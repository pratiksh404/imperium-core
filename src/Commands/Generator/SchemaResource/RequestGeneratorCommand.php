<?php

namespace Pratiksh\Imperium\Commands\Generator\SchemaResource;

use Illuminate\Console\Command;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaRules\SchemaRuleGenerator;
use Pratiksh\Imperium\Traits\Console\NeedsModel;

use function Laravel\Prompts\info;

class RequestGeneratorCommand extends Command
{
    use NeedsModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate schema based request file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $selected_model = $this->getModelFromConsole();

        $model = $selected_model->model;
        $namespace = $selected_model->namespace;

        $generator = new SchemaRuleGenerator($model, $namespace);

        $request = $generator->generate();
        info('Request file created successfully at ['.$request.']');
    }
}
