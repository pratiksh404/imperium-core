<?php

namespace Pratiksh\Imperium\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Pratiksh\Imperium\Services\ServerResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModuleController extends Controller
{
    public function bulkDelete(Request $request, $model)
    {
        // Validate the request
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        // Convert model name to fully qualified class name
        $modelClass = $this->getModelClass($model);

        // Delete the records
        $deleted = $modelClass::withTrashed()->whereIn('id', $validated['ids'])->each(function ($record) {
            $record->trashed() ? $record->forceDelete() : $record->delete();
        });

        return ServerResponse::success('Records deleted successfully')
            ->redirectTo($request->input('redirectTo') ?? route("{$model}.index"))
            ->toResponse();
    }

    public function reorder(Request $request, $model)
    {
        // Validate the request
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);
        // Convert model name to fully qualified class name
        $modelClass = $this->getModelClass($model);

        // Reorder the records
        $modelClass::reorder($validated['ids']);

        return response()->json([
            'success' => true,
            'message' => 'Records reordered successfully',
        ]);
    }

    public function restore(Request $request, $model, $id)
    {
        // Convert model name to fully qualified class name
        $modelClass = $this->getModelClass($model);

        // Restore the record
        $modelClass::withTrashed()->find($id)->restore();

        return ServerResponse::success('Records restored successfully')
            ->redirectTo($request->input('redirectTo') ?? route("{$model}.index"))
            ->toResponse();
    }

    private function getModelClass(string $model): string
    {
        $possibleNamespaces = [
            'App\\Models\\',
            'App\\Models\\Admin\\',
        ];

        $studlyName = Str::studly($model);

        foreach ($possibleNamespaces as $namespace) {
            $class = $namespace . $studlyName;

            if (class_exists($class)) {
                $instance = new $class;

                if (! Schema::hasTable($instance->getTable())) {
                    throw new \RuntimeException("Table not found for model: {$class}");
                }

                return $class;
            }
        }

        throw new ModelNotFoundException("Model not found: {$model}");
    }
}
