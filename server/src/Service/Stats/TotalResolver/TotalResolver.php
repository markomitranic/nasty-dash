<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats\TotalResolver;

use NastyDash\Service\Stats\TotalDTO;
use NastyDash\Service\Stats\TotalListRequestParamsDTO;

interface TotalResolver
{

	/**
	 * @param TotalListRequestParamsDTO $requestParamsDTO
	 * @return TotalDTO[]
	 */
	public function resolve(TotalListRequestParamsDTO $requestParamsDTO): array;

}
