<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats\TotalResolver\MemorySortResolver;

use DateTimeInterface;

class AggregatePeriod
{

	/**
	 * @var OrderSum[]
	 */
	private array $orderSums = [];
	private DateTimeInterface $dateStart;
	private DateTimeInterface $dateEnd;
	private string $dateStartPrimitive;
	private string $dateEndPrimitive;
	private int $orderCount = 0;
	private int $newlyRegisteredCustomers = 0;
	private float $totalRevenue = 0;

	public function __construct(
		DateTimeInterface $dateStart,
		DateTimeInterface $dateEnd
	) {
		$this->dateStart = $dateStart;
		$this->dateEnd = $dateEnd;
		$this->dateStartPrimitive = $this->getDateStart()->format("Y-m-d H:i:s");
		$this->dateEndPrimitive = $this->getDateEnd()->format("Y-m-d H:i:s");
	}

	public function getDateStart(): DateTimeInterface
	{
		return $this->dateStart;
	}

	public function getDateStartPrimitive(): string
	{
		return $this->dateStartPrimitive;
	}

	public function getDateEnd(): DateTimeInterface
	{
		return $this->dateEnd;
	}

	public function getDateEndPrimitive(): string
	{
		return $this->dateEndPrimitive;
	}

	/**
	 * @return OrderSum[]
	 */
	public function getOrderSums(): array
	{
		return $this->orderSums;
	}

	public function addOrderSum(OrderSum $orderSum): self
	{
		$this->orderSums[] = $orderSum;
		$this->orderCount++;
		$this->newlyRegisteredCustomers += $orderSum->getNewCustomer();
		$this->totalRevenue += $orderSum->getItemTotalPrice();
		return $this;
	}

	public function getOrderCount(): int
	{
		return $this->orderCount;
	}

	public function getNewlyRegisteredCustomers(): int
	{
		return $this->newlyRegisteredCustomers;
	}

	public function getTotalRevenue()
	{
		return $this->totalRevenue;
	}

}
