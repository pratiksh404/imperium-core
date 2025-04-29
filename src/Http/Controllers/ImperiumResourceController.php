<?php

namespace Pratiksh\Imperium\Http\Controllers;

use Illuminate\Http\Request;
use Pratiksh\Imperium\Http\Controllers\Controller;

class ImperiumResourceController extends Controller
{
    public function getDependencyValues($module_name, $dependable_field_name, Request $request)
    {
        try {
            $resource = getResource($module_name);
            $form = $resource['form'];
            if (count($form->fields ?? []) > 0) {
                $form_field_names = collect($form->fields)->map(function ($field) {
                    return $field->field;
                })->toArray();
                if (in_array($dependable_field_name, $form_field_names)) {
                    $dependable_field = collect($form->fields)->first(function ($field) use ($dependable_field_name) {
                        return $field->field == $dependable_field_name;
                    });

                    return $dependable_field->getDependencies($request);
                } else {
                    return response()->json(['error' => $module_name . ' resource class does not have any dependable fields ' . $dependable_field_name], 400);
                }
            } else {
                return response()->json(['error' => $module_name . ' resource class does not have any form fields'], 400);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function resourceAction($module_name, $action_name, Request $request)
    {
        try {
            $resource = getResource($module_name);

            return $resource[$action_name]($request);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
