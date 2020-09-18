<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats;

use DateTime;
use DateTimeInterface;
use JsonSerializable;

class TotalDTO implements JsonSerializable
{

	private DateTimeInterface $dateFrom;
	private DateTimeInterface $dateTo;
	private int $orders;
	private float $revenue;
	private int $customers;

	public function __construct(
		DateTimeInterface $dateFrom,
		DateTimeInterface $dateTo,
		int $orders,
		float $revenue,
		int $customers
	) {
		$this->dateFrom = $dateFrom;
		$this->dateTo = $dateTo;
		$this->orders = $orders;
		$this->revenue = $revenue;
		$this->customers = $customers;
	}

	public function getDateFrom(): DateTimeInterface
	{
		return $this->dateFrom;
	}

	public function getDateTo(): DateTimeInterface
	{
		return $this->dateTo;
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
			'dateFrom' => $this->getDateFrom()->format(DateTime::ISO8601),
			'dateTo' => $this->getDateTo()->format(DateTime::ISO8601),
			'orders' => $this->getOrders(),
			'revenue' => $this->getRevenue(),
			'customers' => $this->getCustomers()
		];
	}
}
