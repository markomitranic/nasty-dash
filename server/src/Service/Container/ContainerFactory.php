<?php
declare(strict_types=1);

namespace NastyDash\Service\Container;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use function DI\factory;

class ContainerFactory
{

	public static function create(ServiceDefinitions $serviceDefinitionsRegistry): ContainerInterface
	{
		$containerBuilder = new ContainerBuilder();
		$containerBuilder->addDefinitions(
			self::generateDefinitionsList(...$serviceDefinitionsRegistry->getDefinitions())
		);
		return $containerBuilder->build();
	}

	private static function generateDefinitionsList(Service ...$services): array
	{
		$definitions = [];
		foreach ($services as $service) {
			if ($service->usesFactory()) {
				$definitionHelper = factory($service->getClassname());

				foreach ($service->getParameters() as $argument => $parameter) {
					$definitionHelper->parameter($argument, $parameter);
				}
			} else {
				$definitionHelper = \DI\autowire($service->getClassname());
				foreach ($service->getParameters() as $argument => $parameter) {
					$definitionHelper->constructorParameter($argument, $parameter);
				}
			}

			$definitions[$service->getAlias()] = $definitionHelper;
		}
		return $definitions;
	}

}
