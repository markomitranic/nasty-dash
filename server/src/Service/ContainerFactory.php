<?php

declare(strict_types=1);

namespace NastyDash\Service;

use DI\ContainerBuilder;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

use function DI\factory;

class ContainerFactory
{

	/** @var string[]  */
	const DEFI = [
		LoggerInterface::class => [LoggerFactory::class, 'create'],
	];

	public static function create(): ContainerInterface
	{
		$containerBuilder = new ContainerBuilder();
		$containerBuilder->addDefinitions(self::generateDefinitionsList());
		return $containerBuilder->build();
	}

	private static function generateDefinitionsList(): array
	{
		$definitions = [];
		foreach (self::DEFI as $aliasName => $implementationName) {
			if (is_array($implementationName)) {
				$definitions[$aliasName] = factory($implementationName);
			} else {
				$definitions[$aliasName] = \DI\create($implementationName);
			}
		}
		return $definitions;
	}

}
