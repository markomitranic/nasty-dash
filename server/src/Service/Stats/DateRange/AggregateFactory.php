<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats\DateRange;

class AggregateFactory
{

	const AGGREGATE_HOUR = 'hour';
	const AGGREGATE_DAY = 'day';
	const AGGREGATE_MONTH = 'month';
	const AGGREGATE_YEAR = 'year';

	public function create(string $aggregatePeriod = self::AGGREGATE_DAY): Aggregate
	{
		switch ($aggregatePeriod) {
			case self::AGGREGATE_HOUR:
				return new Hourly();
			case self::AGGREGATE_DAY:
				return new Daily();
			case self::AGGREGATE_MONTH:
				return new Monthly();
			case self::AGGREGATE_YEAR:
				return new Yearly();
			default:
				return new Daily();
		}
	}

}
