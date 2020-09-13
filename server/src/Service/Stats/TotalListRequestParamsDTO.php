<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats;

use DateTimeInterface;

class TotalListRequestParamsDTO
{

	private string $aggregate;
	private DateTimeInterface $dateFrom;
	private DateTimeInterface $dateTo;

	public function __construct(
		string $aggregate,
		DateTimeInterface $dateFrom,
		DateTimeInterface $dateTo
	) {
		$this->aggregate = $aggregate;
		$this->dateFrom = $dateFrom;
		$this->dateTo = $dateTo;
	}

	public function getAggregate(): string
	{
		return $this->aggregate;
	}

	public function getDateFrom(): DateTimeInterface
	{
		return $this->dateFrom;
	}

	public function getDateTo(): DateTimeInterface
	{
		return $this->dateTo;
	}

}
