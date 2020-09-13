<?php
declare(strict_types=1);

namespace NastyDash\Service;

use Middlewares\ErrorHandler;
use Middlewares\FastRoute;
use Middlewares\GzipEncoder;
use Middlewares\RequestHandler;
use Middlewares\Utils\Dispatcher;
use NastyDash\Service\Config\Environment;
use NastyDash\Service\Container\ContainerFactory;
use NastyDash\Service\Container\ServiceDefinitions;
use NastyDash\Service\Middleware\Emitter;
use NastyDash\Service\Middleware\JsonErrorFormatter;
use NastyDash\Service\Middleware\JsonFormatter as JsonFormatterMiddleware;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Psr\Container\ContainerInterface;

class Kernel
{

	const CACHE_DIR = '/tmp/nasty-dash/cache/';

    private string $rootDir;
	private Environment $env;
	private ContainerInterface $container;
	private ServerRequestCreator $requestCreator;
	private Router $router;

	public function __construct()
    {
        $this->rootDir = dirname(__DIR__);
        $this->env = new Environment($this->rootDir);
        $this->container = ContainerFactory::create(
        	new ServiceDefinitions($this->env)
		);
		$psr17Factory = new Psr17Factory();
        $this->requestCreator = new ServerRequestCreator(
			$psr17Factory, // ServerRequestFactory
			$psr17Factory, // UriFactory
			$psr17Factory, // UploadedFileFactory
			$psr17Factory  // StreamFactory
		);
        $this->router = new Router(
        	(bool) !$this->env->get('IN_DEV'),
			self::CACHE_DIR,
			(bool) $this->env->get('IN_DEV'),
		);
    }

    public function handle(): void
    {
		$request = $this->requestCreator->fromGlobals();
		$dispatcher = new Dispatcher([
			new Emitter(),
			new ErrorHandler([new JsonErrorFormatter()]),
			new JsonFormatterMiddleware(),
			new GzipEncoder(),
			new FastRoute($this->router->getDispatcher()),
			new RequestHandler($this->container),
		]);

		$dispatcher->dispatch($request);
    }

}
