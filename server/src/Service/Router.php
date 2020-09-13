<?php
declare(strict_types=1);

namespace NastyDash\Service;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use NastyDash\Service\Controller\Seed;
use NastyDash\Service\Controller\Total;

use function FastRoute\cachedDispatcher;

class Router
{

	/** @var string  */
	const CACHE_NAME = 'route.cache';

    private Dispatcher $router;
	private bool $devEnv;

	public function __construct(
    	bool $cached = true,
		string $cacheDir = __DIR__,
		bool $devEnv = false
	) {
        $this->router = cachedDispatcher(
            [$this, 'routes'],
            [
            	'cacheDisabled' => !$cached,
				'cacheFile' => sprintf('%s/%s', realpath($cacheDir), self::CACHE_NAME)
			]
        );
        $this->devEnv = $devEnv;
    }

	public function routes(RouteCollector $r): void
	{
		$r->get('/api/stats/total', Total::class);

		if ($this->devEnv) {
			$r->get('/api/seed', Seed::class);
		}
	}

    public function getDispatcher(): Dispatcher
    {
        return $this->router;
    }

}
