<?php

namespace Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaForm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Pratiksh\Imperium\Services\Generator\SchemaResource\DatabaseSchema;
use Pratiksh\Imperium\Services\Generator\SchemaResource\SchemaForm\Fields\InputFieldMaker;

class SchemaFormMaker
{
    public FormRequest $request;

    public string $module_name;

    public function __construct(string $module_name)
    {
        $this->module_name = $module_name;

        $requestFileName = Str::studly($module_name).'Request';

        if (! isset(getFilesWithPaths(app_path('Http/Requests'))[$requestFileName])) {
            throw new \Exception('Request file not found');
        } else {
            $this->request = (new (getFilesWithNameSpace(app_path('Http/Requests'))[$requestFileName]));
        }
    }

    public static function make(string $module_name): self
    {
        return new self($module_name);
    }

    public function generateFormCode()
    {
        if (method_exists($this->request, 'rules')) {
            $requestRules = $this->request->rules();
            $databaseColumns = DatabaseSchema::for(strtolower(Str::plural($this->module_name)))->columns();

            $information_data = [];

            foreach ($requestRules as $filed_name => $request_rule) {
                $information_data[$filed_name] = [
                    'request_rules' => $request_rule,
                    'database_column' => $databaseColumns[$filed_name],
                ];
            }

            $fieldCode = '';
            foreach ($information_data as $fieldName => $info) {
                $fieldCode .= (InputFieldMaker::for($info))->grab()."\n";
            }

            return $fieldCode;
        } else {
            throw new \Exception('Request file does not have rules method');
        }
    }

    public function generateInputField(string $fieldName, array $rules): string
    {
        // Create the field code for each input
        $fieldCode = "TextField::make('$fieldName')";

        foreach ($rules as $rule) {
            if (strpos($rule, 'min:') === 0) {
                $minValue = (int) substr($rule, 4);
                $fieldCode .= "->min($minValue)";
            } elseif (strpos($rule, 'max:') === 0) {
                $maxValue = (int) substr($rule, 4);
                $fieldCode .= "->max($maxValue)";
            } elseif ($rule === 'required') {
                $fieldCode .= '->required()';
            } elseif (strpos($rule, 'unique:') === 0) {
                $fieldCode .= "->unique('".substr($rule, 7)."')";
            } elseif (strpos($rule, 'exists:') === 0) {
                $fieldCode .= "->exists('".substr($rule, 7)."')";
            }
        }

        // Assuming 'user_id' needs to be a SelectField
        if ($fieldName === 'user_id') {
            $fieldCode = "SelectField::make('$fieldName', 'User')"
                ."->optionCollection(Imperium::user()->all(), 'name', 'id')";
        }

        return $fieldCode;
    }
}
