<?php
declare(strict_types=1);

namespace NastyDash\Service\Container;

class Service
{

	private string $alias;
	private string $classname;
	private array $parameters;
	private bool $usesFactory;

	public function __construct(string $alias, string $classname, array $parameters = [], bool $usesFactory = false)
	{
		$this->alias = $alias;
		$this->classname = $classname;
		$this->parameters = $parameters;
		$this->usesFactory = $usesFactory;
	}

	public function getAlias(): string
	{
		return $this->alias;
	}

	public function getClassname(): string
	{
		return $this->classname;
	}

	public function getParameters(): array
	{
		return $this->parameters;
	}

	public function usesFactory():bool
	{
		return $this->usesFactory;
	}

}
