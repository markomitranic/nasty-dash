<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats;

use NastyDash\Service\Stats\DateRange\AggregateFactory;
use NastyDash\Service\Stats\TotalResolver\TotalResolver;

class TotalAggregateService
{

	private AggregateFactory $aggregateFactory;
	private TotalResolver $resolver;

	public function __construct(
		AggregateFactory $aggregateFactory,
		TotalResolver $resolver
	) {
		$this->aggregateFactory = $aggregateFactory;
		$this->resolver = $resolver;
	}

	/**
	 * @param TotalListRequestParamsDTO $requestParamsDTO
	 * @return TotalDTO[]
	 */
	public function getAggregate(TotalListRequestParamsDTO $requestParamsDTO): array
	{
		$aggregatePeriod = $this->aggregateFactory
			->create($requestParamsDTO->getAggregate())
			->resolveAggregatePoints(
				$requestParamsDTO->getDateFrom(), $requestParamsDTO->getDateTo()
			);

		return $this->resolver->resolve($aggregatePeriod);
	}

}
