<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats;

use DateTimeInterface;
use NastyDash\Service\Order\Reader;
use NastyDash\Service\Stats\DateRange\AggregateFactory;

class TotalAggregateService
{

	private Reader $orderReader;
	private AggregateFactory $aggregateFactory;

	public function __construct(
		Reader $orderReader,
		AggregateFactory $aggregateFactory
	) {
		$this->orderReader = $orderReader;
		$this->aggregateFactory = $aggregateFactory;
	}

	/**
	 * @param TotalListRequestParamsDTO $requestParamsDTO
	 * @return TotalDTO[]
	 */
	public function getAggregate(TotalListRequestParamsDTO $requestParamsDTO): array
	{
		$results = [];

		$aggregatePeriod = $this->aggregateFactory
			->create($requestParamsDTO->getAggregate())
			->resolveAggregatePoints(
				$requestParamsDTO->getDateFrom(), $requestParamsDTO->getDateTo()
			);

		/** @var DateTimeInterface $date */
		foreach ($aggregatePeriod as $date) {
			$periodEnd = date_add(new \DateTime($date->format('c')), $aggregatePeriod->getDateInterval());

//			$orders = $this->orderReader->findAllInDateRange($date, $periodEnd);
//			$revenue = $this->orderReader->findAllInDateRange($date, $periodEnd);
//			$customers = $this->orderReader->findAllInDateRange($date, $periodEnd);
//			POSLEDNJE STO SAM RADIO TREBA DA NAPISEM OVE TRI LINIJE
//			TAKO DA BUDU SQL KVERIJI U READERU NEGDE

			$results[] = new TotalDTO($date, 0, 0, 0);
		}


		return $results;
	}



}
