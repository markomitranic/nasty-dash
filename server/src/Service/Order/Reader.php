<?php
declare(strict_types=1);

namespace NastyDash\Service\Order;

use DateTimeInterface;

interface Reader
{

	public function findById(int $id): Order;

	/**
	 * @return Order[]
	 */
	public function findAll(): array;

	/**
	 * @param DateTimeInterface $from
	 * @param DateTimeInterface $to
	 * @return Order[]
	 */
	public function findAllInDateRange(DateTimeInterface $from, DateTimeInterface $to): array;

}
