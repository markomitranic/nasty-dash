<?php

declare(strict_types=1);

namespace NastyDash\Service;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LoggerFactory
{

	public static function create(): LoggerInterface
	{
		$logger = new Logger('api');
		$logger->pushHandler(new StreamHandler(
			'php://stdout',
			Logger::WARNING
		));
		return $logger;
	}

}
