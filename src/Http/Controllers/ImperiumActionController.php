<?php

namespace Pratiksh\Imperium\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Pratiksh\Imperium\Contracts\Imperium\HasActionInterface;
use Pratiksh\Imperium\Services\Action\ActionResponse;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaDatabase\SchemaMigrationGenerator;

class ImperiumActionController extends Controller implements HasActionInterface
{
    public function handleBatchActions(Request $request)
    {
        try {
            $responses = [];
            if ($request->has('batchActions')) {
                $batchActions = $request->batchActions;
                foreach ($batchActions as $index => $batchAction) {
                    $action_name = $batchAction['action'] ?? null;
                    if (! is_null($action_name)) {
                        if (method_exists($this, $action_name)) {
                            $responses[] = $this->$action_name($batchAction);
                        } else {
                            $responses[] = ActionResponse::error('#'.($index + 1).' Batch action not found');
                        }
                    } else {
                        $responses[] = ActionResponse::error('#'.($index + 1).' Batch action not provided');
                    }
                }
            }

            return $responses;
        } catch (\Throwable $th) {
            return ActionResponse::error($th->getMessage());
        }
    }

    public function handleAction(Request $request): JsonResponse
    {
        try {
            if ($request->has('action')) {
                $action_name = $request->action;
                if (method_exists($this, $action_name)) {
                    return $this->$action_name($request);
                } else {
                    return ActionResponse::error($action_name.' method not found in '.get_class($this));
                }
            } else {
                return ActionResponse::error('Action not provided');
            }
        } catch (\Throwable $th) {
            return ActionResponse::error($th->getMessage());
        }
    }

    // Imperium Actions
    public function generateResourceMigration(Request $request): JsonResponse
    {
        $request->validate([
            'table_name' => 'required',
            'schema' => 'required',
        ]);
        $table_name = $request->table_name;
        $schema = $request->schema;

        try {
            $migration_file = SchemaMigrationGenerator::for($table_name)->schemas($schema)->generate();

            return ActionResponse::success([
                'table_name' => $request->table_name,
                'schema' => $schema,
            ], 'Migration generated successfully');
        } catch (\Throwable $th) {
            return ActionResponse::error($th->getMessage());
        }
    }

    public function runMigration(Request $request): JsonResponse
    {
        try {
            Artisan::call('migrate');

            return ActionResponse::success([], 'Migration run successfully');
        } catch (\Throwable $th) {
            return ActionResponse::error($th->getMessage());
        }
    }
}
