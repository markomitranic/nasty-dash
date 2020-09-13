<?php
declare(strict_types=1);

namespace NastyDash\Service\Container;

use Monolog\Logger;
use NastyDash\Service\Config\Environment;
use NastyDash\Service\Database\ConnectionParams;
use NastyDash\Service\LoggerFactory;

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
				[
					'name' => 'api',
					'output' => LoggerFactory::OUTPUT_STDOUT,
					'level' => Logger::WARNING
				],
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
			new Service(
				\NastyDash\Service\Customer\Reader::class,
				\NastyDash\Service\Customer\Reader\Mysql::class
			),
			new Service(
				\NastyDash\Service\Customer\Saver::class,
				\NastyDash\Service\Customer\Saver\Mysql::class
			),
			new Service(
				\NastyDash\Service\Order\Reader::class,
				\NastyDash\Service\Order\Reader\Mysql::class
			),
			new Service(
				\NastyDash\Service\Order\Saver::class,
				\NastyDash\Service\Order\Saver\Mysql::class
			),
			new Service(
				\NastyDash\Service\Item\Reader::class,
				\NastyDash\Service\Item\Reader\Mysql::class
			),
			new Service(
				\NastyDash\Service\Item\Saver::class,
				\NastyDash\Service\Item\Saver\Mysql::class
			)
		];
	}

}
