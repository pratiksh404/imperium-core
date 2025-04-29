<?php

namespace Pratiksh\Imperium\Services\Generator\Scaffold;

use Illuminate\Support\Str;
use Pratiksh\Imperium\Contracts\Core\Generator\GeneratorInterface;
use Pratiksh\Imperium\Services\Generator\Generator;

class ImperiumResourceGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name, ?string $model_namespace = null)
    {
        parent::__construct($name, $model_namespace);
    }

    public function generate()
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNameLowercase}}',
                '{{modelNamePluralLowercase}}',
                '{{modelNamePluralUppercase}}',
                '{{modelNamespace}}',
            ],
            [
                $this->name,
                strtolower($this->name),
                strtolower(Str::plural($this->name)),
                Str::ucfirst(Str::plural($this->name)),
                $this->model_namespace,
            ],
            $this->getStub('ImperiumResource'),
        );

        // Adding Resource to menu
        $this->addToMenu();

        return $this->makeFile(app_path('Imperium/Resource/' . $this->name . 'Resource.php'), $template);
    }

    private function addToMenu()
    {
        $menuPath = app_path('Imperium/Application.php');
        $resourcePath = "\Pratiksh\Imperium\Resource\\" . $this->name . 'Resource::class';
        $newLine = 'MenuResourceItem::make(' . $resourcePath . '),';

        if (file_exists($menuPath)) {
            // Read the existing file content
            $content = file_get_contents($menuPath);

            // Match the `return []` inside the `menu()` method
            $pattern = '/public\s+function\s+menu\(\)\s*:\s*Menu\s*\{\s*return\s*Menu::make\(\[\s*(.*)\s*\]\);\s*\}/s';

            if (preg_match($pattern, $content, $matches)) {
                // Check if the line already exists
                if (strpos($matches[1], trim($newLine)) === false) {
                    // Insert the new line before the closing `]`
                    $arrayContent = rtrim($matches[1]);
                    $modifiedArrayContent = $arrayContent . "\n                " . $newLine;

                    // Replace the matched return block with the updated block
                    $replacement = preg_replace(
                        $pattern,
                        "public function menu(): Menu\n{\nreturn Menu::make([\n$modifiedArrayContent\n]);\n}",
                        $content
                    );

                    // Write back the modified content to the file
                    if ($replacement !== $content) {
                        file_put_contents($menuPath, $replacement);
                        echo 'Line added successfully.';
                    } else {
                        echo 'No changes were made. Pattern not found.';
                    }
                } else {
                    echo 'The line already exists. No changes were made.';
                }
            } else {
                echo 'Could not find the menu() method structure in the file.';
            }
        } else {
            echo 'Configuration file not found.';
        }
    }
}
