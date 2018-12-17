<?php
/**
 *
 */

declare(strict_types=1);

namespace Zend\Expressive\Doctrine\Migrations;

use Doctrine\Migrations\Configuration\Configuration as MigrationsConfiguration;

/**
 * Class ConfigProvider
 *
 * @package Zend\Expressive\Doctrine\Migrations
 */
class ConfigProvider
{
    /**
     * Return configuration for this component.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * Return dependency mappings for this component.
     *
     * @return array
     */
    public function getDependencyConfig()
    {
        return [
            'factories' => [
                MigrationsConfiguration::class => Container\MigrationsConfigurationFactory::class,
                'doctrine.migrations_cmd.execute' => [Container\MigrationsCommandFactory::class, 'execute'],
                'doctrine.migrations_cmd.generate' => [Container\MigrationsCommandFactory::class, 'generate'],
                'doctrine.migrations_cmd.migrate' => [Container\MigrationsCommandFactory::class, 'migrate'],
                'doctrine.migrations_cmd.status' => [Container\MigrationsCommandFactory::class, 'status'],
                'doctrine.migrations_cmd.version' => [Container\MigrationsCommandFactory::class, 'version'],
                'doctrine.migrations_cmd.diff' => [Container\MigrationsCommandFactory::class, 'diff'],
                'doctrine.migrations_cmd.latest' => [Container\MigrationsCommandFactory::class, 'latest'],
            ],
        ];
    }
}
