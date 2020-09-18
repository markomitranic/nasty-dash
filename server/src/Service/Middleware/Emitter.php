<?php
declare(strict_types=1);

namespace NastyDash\Service\Middleware;

use Narrowspark\HttpEmitter\AbstractSapiEmitter;
use Narrowspark\HttpEmitter\SapiEmitter;
use Narrowspark\HttpEmitter\Util;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Emitter implements MiddlewareInterface
{

	private AbstractSapiEmitter $emitter;

	public function __construct()
	{
		$this->emitter = new SapiEmitter();
	}

	public function process(
		ServerRequestInterface $request,
		RequestHandlerInterface $handler
	): ResponseInterface {
		$response = $handler->handle($request);

		$response = Util::injectContentLength($response);
		$this->emitter->emit($response);

		return $response;
	}
}
