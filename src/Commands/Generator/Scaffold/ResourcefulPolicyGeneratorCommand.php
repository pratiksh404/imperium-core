<?php

namespace Pratiksh\Imperium\Commands\Generator\Scaffold;

use Illuminate\Console\Command;
use Pratiksh\Imperium\Services\Generator\Scaffold\ResourcefulPolicyGenerator;
use Pratiksh\Imperium\Traits\Console\NeedsModel;

use function Laravel\Prompts\info;

class ResourcefulPolicyGeneratorCommand extends Command
{
    use NeedsModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate policy compatible with imperium authorization system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $selected_model = $this->getModelFromConsole();

        $model = $selected_model->model;
        $namespace = $selected_model->namespace;

        $generator = new ResourcefulPolicyGenerator($model, $namespace);

        $policy = $generator->generateResourcefulPolicy();
        info('Policy created successfully at ['.$policy.']');
    }
}
