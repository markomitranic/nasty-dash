<?php
declare(strict_types=1);

namespace NastyDash\Service\Customer;

use Traversable;

interface Reader
{

	public function findById(int $id): Customer;

	/**
	 * @return Customer[]
	 */
	public function findAll(): array;

}
