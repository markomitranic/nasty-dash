<?php
declare(strict_types=1);

namespace NastyDash\Service\Controller;

use Psr\Log\LoggerInterface;

abstract class Controller
{

	protected LoggerInterface $logger;

	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

}
