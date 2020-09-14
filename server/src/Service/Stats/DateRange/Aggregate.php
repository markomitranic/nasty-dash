<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats\DateRange;

use DateInterval;
use DatePeriod;

abstract class Aggregate
{

	protected string $period = 'P1D';

	public function resolveAggregatePoints(\DateTimeInterface $from, \DateTimeInterface $to): DatePeriod
	{
		return new DatePeriod($from, $this->getInterval(), $to);
	}

	public function getInterval(): DateInterval
	{
		return new DateInterval($this->period);
	}

	protected function getAggregatePeriod(): string
	{
		return $this->period;
	}
}
