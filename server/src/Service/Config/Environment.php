<?php
declare(strict_types=1);

namespace NastyDash\Service\Config;

use Symfony\Component\Dotenv\Dotenv;

class Environment {

	private array $environment = [];

	public function __construct(string $rootDir)
	{
		$dotenv = new Dotenv();
		$dotenv->loadEnv($rootDir . '/.env');
		$this->environment = $_ENV;
	}

    private function getAll(): array
    {
        return $this->environment;
    }

    public function get(string $key): string
	{
		if (array_key_exists($key, $this->environment)) {
			return $this->environment[$key];
		}

		return '';
	}

}

