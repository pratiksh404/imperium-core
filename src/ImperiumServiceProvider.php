<?php

namespace Pratiksh\Imperium;

use Pratiksh\Imperium\Commands\Authorization\GenerateBreadCommand;
use Pratiksh\Imperium\Commands\Generator\Scaffold\ImperiumResourceGeneratorCommand;
use Pratiksh\Imperium\Commands\Generator\Scaffold\ResourcefulControllerGeneratorCommand;
use Pratiksh\Imperium\Commands\Generator\Scaffold\ResourcefulPolicyGeneratorCommand;
use Pratiksh\Imperium\Commands\Generator\Scaffold\ResourcefulRepositoryGeneratorCommand;
use Pratiksh\Imperium\Commands\Generator\Scaffold\ScaffoldGeneratorCommand;
use Pratiksh\Imperium\Commands\Generator\SchemaResource\RequestGeneratorCommand;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ImperiumServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('imperium')
            ->hasCommands([
                // Authorization
                GenerateBreadCommand::class,
                // Generator Scaffold
                ImperiumResourceGeneratorCommand::class,
                ResourcefulControllerGeneratorCommand::class,
                ResourcefulPolicyGeneratorCommand::class,
                ResourcefulRepositoryGeneratorCommand::class,
                ScaffoldGeneratorCommand::class,
                // Generator Schema
                RequestGeneratorCommand::class,
            ])
            ->hasRoute('web')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->setDescription('Install the Imperium package')
                    ->publishConfigFile()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub('pratiksh404/imperium');
            });
    }
}
