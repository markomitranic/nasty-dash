<?php
declare(strict_types=1);

namespace NastyDash\Service;

use Middlewares\ErrorFormatter\JsonFormatter;
use Middlewares\ErrorHandler;
use Middlewares\FastRoute;
use Middlewares\GzipEncoder;
use Middlewares\RequestHandler;
use Middlewares\Utils\Dispatcher;
use NastyDash\Service\Middleware\Emitter;
use NastyDash\Service\Middleware\JsonFormatter as JsonFormatterMiddleware;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Container\ContainerInterface;

class Kernel
{
	/** @var string  */
	const CACHE_DIR = '/tmp/nasty-dash/cache/';

    private string $rootDir;
	private ContainerInterface $container;
	private ServerRequestCreator $requestCreator;
	private Router $router;

	public function __construct()
    {
        $this->rootDir = dirname(__DIR__);
        $this->container = ContainerFactory::create();
		$psr17Factory = new Psr17Factory();
        $this->requestCreator = new ServerRequestCreator(
			$psr17Factory, // ServerRequestFactory
			$psr17Factory, // UriFactory
			$psr17Factory, // UploadedFileFactory
			$psr17Factory  // StreamFactory
		);
        $this->router = new Router(true, self::CACHE_DIR);
    }

    public function handle(): void
    {
		$request = $this->requestCreator->fromGlobals();
		$dispatcher = new Dispatcher([
			new Emitter(),
			new ErrorHandler([new JsonFormatter()]),
			new JsonFormatterMiddleware(),
			new GzipEncoder(),
			new FastRoute($this->router->getDispatcher()),
			new RequestHandler($this->container),
		]);

		$dispatcher->dispatch($request);
    }

}
