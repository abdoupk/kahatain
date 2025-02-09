<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Exception\Configuration\InvalidConfigurationException;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;

try {
    return RectorConfig::configure()
        ->withPaths([
            __DIR__.'/app',
            __DIR__.'/bootstrap',
            __DIR__.'/config',
            __DIR__.'/lang',
            __DIR__.'/node_modules',
            __DIR__.'/public',
            __DIR__.'/resources',
            __DIR__.'/routes',
            __DIR__.'/tests',
        ])
        // uncomment to reach your current PHP version
        ->withPhpSets(php83: true)
        ->withRules([
            AddReturnTypeDeclarationRector::class,
            AddOverrideAttributeToOverriddenMethodsRector::class,
        ])
        ->withPreparedSets(
            deadCode: true,
            codeQuality: true,
            privatization: true,
            earlyReturn: true,
            strictBooleans: true,
        )
        ->withTypeCoverageLevel(3);
} catch (InvalidConfigurationException $e) {
}
