<?php
declare(strict_types=1);

namespace NastyDash\Service;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use NastyDash\Service\Controller\Orders;
use function FastRoute\cachedDispatcher;

class Router
{

	/** @var string  */
	const CACHE_NAME = 'route.cache';

    private Dispatcher $router;

    public function __construct(bool $cached = true, string $cacheDir = __DIR__)
    {
        $this->router = cachedDispatcher(
            [$this, 'routes'],
            [
            	'cacheDisabled' => !$cached,
				'cacheFile' => sprintf('%s/%s', realpath($cacheDir), self::CACHE_NAME)
			]
        );
    }

	public function routes(RouteCollector $r): void
	{
		$r->get('/api/orders', Orders::class);
	}

    public function getDispatcher(): Dispatcher
    {
        return $this->router;
    }

}
