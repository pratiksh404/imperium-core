<?php

namespace Pratiksh\Imperium\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Pratiksh\Imperium\Http\Controllers\Controller;

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

        return redirect()->back()->with([
            'success' => $deleted
                ? "{$deleted} records deleted successfully"
                : 'No records deleted',
        ]);
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

        return redirect()->back()->with([
            'success' => 'Records reordered successfully',
        ]);
    }

    public function restore($model, $id)
    {
        // Convert model name to fully qualified class name
        $modelClass = $this->getModelClass($model);

        // Restore the record
        $modelClass::withTrashed()->find($id)->restore();

        return redirect()->back()->with([
            'success' => 'Record restored successfully',
        ]);
    }

    private function getModelClass($model)
    {
        try {
            // Convert model name to fully qualified class name
            $modelClass = 'App\\Models\\' . ucfirst($model);

            // Check if the model exists
            if (! class_exists($modelClass)) {
                $modelClass = 'App\\Models\\Admin\\' . ucfirst($model);

                if (! class_exists($modelClass)) {
                    return redirect()->back()->with([
                        'error' => 'Model not found',
                    ]);
                }
            }

            // Check if the model has a corresponding table
            if (! Schema::hasTable((new $modelClass)->getTable())) {
                return redirect()->back()->with([
                    'error' => 'Invalid model table',
                ]);
            }

            return $modelClass;
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
