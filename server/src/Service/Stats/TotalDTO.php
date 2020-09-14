<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats;

use DateTime;
use DateTimeInterface;
use JsonSerializable;

class TotalDTO implements JsonSerializable
{

	private DateTimeInterface $dateTime;
	private int $orders;
	private float $revenue;
	private int $customers;

	public function __construct(
		DateTimeInterface $dateTime,
		int $orders,
		float $revenue,
		int $customers
	) {
		$this->dateTime = $dateTime;
		$this->orders = $orders;
		$this->revenue = $revenue;
		$this->customers = $customers;
	}

	public function getDateTime(): DateTimeInterface
	{
		return $this->dateTime;
	}

	public function getOrders(): int
	{
		return $this->orders;
	}

	public function getRevenue(): float
	{
		return $this->revenue;
	}

	public function getCustomers(): int
	{
		return $this->customers;
	}

	public function jsonSerialize()
	{
		return [
			'dateTime' => $this->getDateTime()->format(DateTime::ISO8601),
			'orders' => $this->getOrders(),
			'revenue' => $this->getRevenue(),
			'customers' => $this->getCustomers()
		];
	}
}
