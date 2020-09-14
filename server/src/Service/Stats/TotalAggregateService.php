<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats;

use NastyDash\Service\Stats\TotalResolver\PrimitiveResolver;

class TotalAggregateService
{

	private PrimitiveResolver $primitiveResolver;

	public function __construct(
		PrimitiveResolver $primitiveResolver
	) {
		$this->primitiveResolver = $primitiveResolver;
	}

	/**
	 * @param TotalListRequestParamsDTO $requestParamsDTO
	 * @return TotalDTO[]
	 */
	public function getAggregate(TotalListRequestParamsDTO $requestParamsDTO): array
	{
		return $this->primitiveResolver->resolve($requestParamsDTO);
	}

}
