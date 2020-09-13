<?php
declare(strict_types=1);

namespace NastyDash\Service\Container;

use NastyDash\Service\Config\Environment;
use NastyDash\Service\Database\ConnectionParams;

final class ServiceDefinitions
{

	private Environment $env;

	public function __construct(Environment $env)
	{
		$this->env = $env;
	}

	public function getDefinitions(): array
	{
		return [
			new Service(
				\Psr\Log\LoggerInterface::class,
				\NastyDash\Service\LoggerFactory::class,
				['name' => 'api'],
				true
			),
		];
	}

}
