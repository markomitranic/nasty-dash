<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats\TotalResolver;

use DateTimeImmutable;
use DateTimeInterface;
use NastyDash\Service\Database\PDO;
use NastyDash\Service\Stats\DateRange\AggregateFactory;
use NastyDash\Service\Stats\TotalDTO;
use NastyDash\Service\Stats\TotalListRequestParamsDTO;

class MemorySortResolver implements TotalResolver
{

	private const STATEMENT = 'SELECT
			order.purchase_date,
			(customer.created_at > order.purchase_date) AS newCustomer,
			SUM(item.price * item.quantity) AS itemTotalPrice
		FROM `order`
		LEFT JOIN `customer` ON order.customer_id=customer.id
		JOIN `item` ON item.order_id = order.id GROUP BY order.id;
		WHERE `purchase_date` > :dateFrom AND `purchase_date` < :dateTo;';

	private PDO $pdo;
	private AggregateFactory $aggregateFactory;

	public function __construct(
		PDO $pdo,
		AggregateFactory $aggregateFactory
	) {
		$this->pdo = $pdo;
		$this->aggregateFactory = $aggregateFactory;
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

		$aggregatePeriods = [];
		/** @var DateTimeInterface $date */
		foreach ($queryDatePeriod as $date) {
			$dateEnd = $date->add($queryDatePeriod->getDateInterval());
			$aggregatePeriods[] = [
				'dateStart' => $date,
				'dateStartPrimitive' => $date->format("Y-m-d H:i:s"),
				'dateEnd' => $dateEnd,
				'dateEndPrimitive' => $dateEnd->format("Y-m-d H:i:s"),
				'orders' => []
			];
		}

		$orders = $this->getResults($queryDatePeriod->getStartDate(), $queryDatePeriod->getEndDate());

		foreach ($orders as $order) {
			foreach ($aggregatePeriods as $key => $aggregatePeriod) {
				if ($order['purchase_date'] >= $aggregatePeriod['dateStartPrimitive'] && $order['purchase_date'] < $aggregatePeriod['dateEndPrimitive']) {
					$aggregatePeriods[$key]['orders'][] = $order;
				}
			}
		}

		$results = [];
		foreach ($aggregatePeriods as $aggregatePeriod) {
			$revenue = $this->sumRevenue($aggregatePeriod['orders']);
			$customers = $this->countNewCustomers($aggregatePeriod['orders']);

			$results[] = new TotalDTO($aggregatePeriod['dateStart'], $aggregatePeriod['dateEnd'], count($aggregatePeriod['orders']), $revenue, $customers);
		}

		return $results;
	}

	private function transformDate($order)
	{
		return [
			'pruchase_date' => new DateTimeImmutable($order['purchase_date']),
			'newCustomer' => (bool) $order['newCustomer'],
			'itemTotalPrice' => $order['itemTotalPrice']
		];
	}

	private function sumRevenue(array $results): float
	{
		$revenue = 0;
		foreach ($results as $result) {
			$revenue+= $result['itemTotalPrice'];
		}
		return $revenue;
	}

	private function countNewCustomers(array $results): int
	{
		$customers = 0;
		foreach ($results as $result) {
			if ($result['newCustomer']) {
				$customers++;
			}
		}
		return $customers;
	}

	public function getResults(DateTimeInterface $startDate, DateTimeInterface $endDate)
	{
		$statement = $this->pdo->prepare(self::STATEMENT);

		$params = [
			'dateFrom' => $startDate->format("Y-m-d H:i:s"),
			'dateTo' => $endDate->format("Y-m-d H:i:s")
		];
		$statement->execute($params);
		return $statement->fetchAll();
	}

}
