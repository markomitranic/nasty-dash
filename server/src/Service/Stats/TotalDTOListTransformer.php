<?php

declare(strict_types=1);


namespace NastyDash\Service\Stats;


use stdClass;

class TotalDTOListTransformer
{

	/**
	 * @param TotalDTO ...$totals
	 * @return stdClass[]
	 */
	public function transform(TotalDTO ...$totals): array
	{
		$output = [];
		foreach ($totals as $total) {
			$output[] = $this->transformTotal($total);
		}
		return $output;
	}

	private function transformTotal(TotalDTO $totalDTO): stdClass
	{
		$output = new stdClass();
		$output->d = $totalDTO->getCustomers();
		$output->d = $totalDTO->getRevenue();
		$output->d = $totalDTO->getOrders();
		$output->d = $totalDTO->getDateTime();

		return $output;
	}

}
