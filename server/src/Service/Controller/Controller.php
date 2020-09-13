<?php
declare(strict_types=1);

namespace NastyDash\Service\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

abstract class Controller
{

	protected LoggerInterface $logger;

	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	/**
	 * Borrowed from Httpfoundation's Request toString
	 * @param ServerRequestInterface $request
	 */
	protected function logRequest(ServerRequestInterface $request): void
	{
		$content = $request->getBody();

		$cookieHeader = '';
		$cookies = [];
		foreach ($request->getCookieParams() as $k => $v) {
			$cookies[] = $k.'='.$v;
		}
		if (!empty($cookies)) {
			$cookieHeader = 'Cookie: '.implode('; ', $cookies)."\r\n";
		}

		$this->logger->critical(sprintf(
			'%s %s %s',
			$request->getMethod(),
			$request->getUri(),
			json_encode($request->getHeaders()).
				 $cookieHeader."\r\n".
				 $content
		));
	}

}
