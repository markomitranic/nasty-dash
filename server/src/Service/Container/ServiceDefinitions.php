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
			new Service(
				\NastyDash\Service\Database\PDO::class,
				\NastyDash\Service\Database\ConnectionFactory::class,
				[
					'connectionParams' => new ConnectionParams(
						$this->env->get('MYSQL_HOST'),
						$this->env->get('MYSQL_DATABASE'),
						$this->env->get('MYSQL_USER'),
						$this->env->get('MYSQL_PASSWORD'),
					)
				],
				true
			),
		];
	}

}
