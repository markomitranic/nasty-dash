<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats;

use NastyDash\Service\Stats\TotalResolver\TotalResolver;

class TotalAggregateService
{

	private TotalResolver $resolver;

	public function __construct(
		TotalResolver $resolver
	) {
		$this->resolver = $resolver;
	}

	/**
	 * @param TotalListRequestParamsDTO $requestParamsDTO
	 * @return TotalDTO[]
	 */
	public function getAggregate(TotalListRequestParamsDTO $requestParamsDTO): array
	{
		return $this->resolver->resolve($requestParamsDTO);
	}

}
