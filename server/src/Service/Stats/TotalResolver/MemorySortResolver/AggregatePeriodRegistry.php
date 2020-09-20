<?php

declare(strict_types=1);


namespace NastyDash\Service\Stats\TotalResolver\MemorySortResolver;


use DatePeriod;
use DateTimeInterface;

class AggregatePeriodRegistry
{

	/**
	 * @var AggregatePeriod[]
	 */
	private array $periods = [];

	public function __construct(DatePeriod $queryDatePeriod) {
		/** @var DateTimeInterface $date */
		foreach ($queryDatePeriod as $date) {
			$dateEnd = $date->add($queryDatePeriod->getDateInterval());
			$this->periods[] = new AggregatePeriod($date, $dateEnd);
		}
	}

	/**
	 * @return AggregatePeriod[]
	 */
	public function getPeriods(): array
	{
		return $this->periods;
	}

	public function addRecord(OrderSum $orderSum): self
	{
		foreach ($this->periods as $aggregatePeriod) {
			if ($orderSum->getPurchaseDate() >= $aggregatePeriod->getDateStartPrimitive()
				&& $orderSum->getPurchaseDate() < $aggregatePeriod->getDateEndPrimitive()) {
				$aggregatePeriod->addOrderSum($orderSum);
			}
		}
		return $this;
	}

}
