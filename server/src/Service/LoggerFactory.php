<?php
declare(strict_types=1);

namespace NastyDash\Service;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LoggerFactory
{

	const OUTPUT_STDOUT = 'php://stdout';

	public function __invoke(
		string $name,
		string $output = self::OUTPUT_STDOUT,
		int $level = Logger::WARNING
	): LoggerInterface {
		$logger = new Logger($name);
		$logger->pushHandler(new StreamHandler($output, $level));
		return $logger;
	}

}
