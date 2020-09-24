<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats\TotalResolver;

use DatePeriod;
use NastyDash\Service\Stats\TotalDTO;

interface TotalResolver
{

	/**
	 * @param DatePeriod $period
	 * @return TotalDTO[]
	 */
	public function resolve(DatePeriod $period): array;

}
