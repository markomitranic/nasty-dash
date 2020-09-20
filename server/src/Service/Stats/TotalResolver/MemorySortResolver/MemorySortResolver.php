<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats\TotalResolver\MemorySortResolver;

use DateTimeInterface;
use NastyDash\Service\Database\PDO;
use NastyDash\Service\Stats\DateRange\AggregateFactory;
use NastyDash\Service\Stats\TotalDTO;
use NastyDash\Service\Stats\TotalListRequestParamsDTO;
use NastyDash\Service\Stats\TotalResolver\TotalResolver;
use PDOStatement;

class MemorySortResolver implements TotalResolver
{

	private const SUM_JOIN_STATEMENT = 'SELECT
			order.purchase_date,
			(customer.created_at > order.purchase_date) AS newCustomer,
			SUM(item.price * item.quantity) AS itemTotalPrice
		FROM `order`
		LEFT JOIN `customer` ON order.customer_id=customer.id
		JOIN `item` ON item.order_id = order.id GROUP BY order.id;
		WHERE `purchase_date` > :dateFrom AND `purchase_date` < :dateTo;';

	private PDO $pdo;
	private AggregateFactory $aggregateFactory;
	private PDOStatement $sumJoinStatement;

	public function __construct(
		PDO $pdo,
		AggregateFactory $aggregateFactory
	) {
		$this->pdo = $pdo;
		$this->aggregateFactory = $aggregateFactory;
		$this->sumJoinStatement = $this->pdo->prepare(self::SUM_JOIN_STATEMENT);
		$this->sumJoinStatement->setFetchMode(PDO::FETCH_CLASS, OrderSum::class);
	}

	/**
	 * @param TotalListRequestParamsDTO $requestParamsDTO
	 * @return TotalDTO[]
	 */
	public function resolve(TotalListRequestParamsDTO $requestParamsDTO): array
	{
		$queryDatePeriod = $this->aggregateFactory
			->create($requestParamsDTO->getAggregate())
			->resolveAggregatePoints(
				$requestParamsDTO->getDateFrom(), $requestParamsDTO->getDateTo()
			);

		/** @var AggregatePeriod $aggregatePeriods */
		$aggregatePeriods = [];
		/** @var DateTimeInterface $date */
		foreach ($queryDatePeriod as $date) {
			$dateEnd = $date->add($queryDatePeriod->getDateInterval());
			$aggregatePeriods[] = new AggregatePeriod($date, $dateEnd);
		}

		$orderSumsCollection = $this->getResults($queryDatePeriod->getStartDate(), $queryDatePeriod->getEndDate());
		foreach ($orderSumsCollection as $orderSum) {
			foreach ($aggregatePeriods as $aggregatePeriod) {
				if ($orderSum->getPurchaseDate() >= $aggregatePeriod->getDateStartPrimitive()
					&& $orderSum->getPurchaseDate() < $aggregatePeriod->getDateEndPrimitive()) {
					$aggregatePeriod->addOrderSum($orderSum);
				}
			}
		}

		$results = [];
		foreach ($aggregatePeriods as $aggregatePeriod) {
			$results[] = new TotalDTO(
				$aggregatePeriod->getDateStart(),
				$aggregatePeriod->getDateEnd(),
				$aggregatePeriod->getOrderCount(),
				$aggregatePeriod->getTotalRevenue(),
				$aggregatePeriod->getNewlyRegisteredCustomers()
			);
		}

		return $results;
	}

	/**
	 * @param DateTimeInterface $startDate
	 * @param DateTimeInterface $endDate
	 * @return OrderSum[]
	 */
	public function getResults(DateTimeInterface $startDate, DateTimeInterface $endDate): array
	{
		$this->sumJoinStatement->execute([
			'dateFrom' => $startDate->format("Y-m-d H:i:s"),
			'dateTo' => $endDate->format("Y-m-d H:i:s")
		]);
		return $this->sumJoinStatement->fetchAll();
	}

}
