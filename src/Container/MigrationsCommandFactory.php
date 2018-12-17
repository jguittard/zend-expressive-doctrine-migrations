<?php
/**
 *
 */

declare(strict_types=1);

namespace Zend\Expressive\Doctrine\Migrations\Container;

use Doctrine\Migrations\Tools\Console\Command\AbstractCommand;
use Doctrine\Migrations\Configuration\Configuration as MigrationsConfiguration;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Doctrine\Exception;

/**
 * Class MigrationsCommandFactory
 *
 * @package Zend\Expressive\Doctrine\Migrations\Container
 */
class MigrationsCommandFactory
{
    /**
     * @var string
     */
    private $commandKey;

    /**
     * MigrationsCommandFactory constructor.
     *
     * @param string $commandKey
     */
    public function __construct($commandKey)
    {
        $this->commandKey = ucfirst(strtolower($commandKey));
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (! array_key_exists(0, $arguments) || ! $arguments[0] instanceof ContainerInterface) {
            throw new Exception\DomainException(sprintf(
                'The first argument must be of type %s',
                ContainerInterface::class
            ));
        }
        return (new static($name))->__invoke($arguments[0]);
    }

    /**
     * @param ContainerInterface $container
     * @return AbstractCommand
     */
    public function __invoke(ContainerInterface $container): AbstractCommand
    {
        $className = sprintf('Doctrine\Migrations\Tools\Console\Command\%sCommand', $this->commandKey);
        $configuration = $container->get(MigrationsConfiguration::class);

        /* @var $command \Doctrine\Migrations\Tools\Console\Command\AbstractCommand */
        $command = new $className;
        $command->setMigrationConfiguration($configuration);

        return $command;
    }
}
