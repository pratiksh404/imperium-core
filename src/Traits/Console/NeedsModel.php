<?php

namespace Pratiksh\Imperium\Traits\Console;

use Illuminate\Support\Str;

use function Laravel\Prompts\search;

trait NeedsModel
{
    public function getModelFromConsole()
    {

        $models = getAllModels();
        $namespace = search(
            label: 'Search for the model',
            options: fn (string $value) => collect($models)
                ->filter(fn ($namespace, $modelName) => Str::contains($namespace, $value, ignoreCase: true))
                ->values()
                ->all(),
        );

        $model = class_basename($namespace);

        return json_decode(json_encode([
            'namespace' => $namespace,
            'model' => $model,
        ]));
    }
}
