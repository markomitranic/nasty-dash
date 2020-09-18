<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats\TotalResolver;

use DateTime;
use DateTimeInterface;
use NastyDash\Service\Customer\Reader as CustomerReader;
use NastyDash\Service\Item\Reader as ItemReader;
use NastyDash\Service\Order\Order;
use NastyDash\Service\Order\Reader as OrderReader;
use NastyDash\Service\Stats\DateRange\AggregateFactory;
use NastyDash\Service\Stats\TotalDTO;
use NastyDash\Service\Stats\TotalListRequestParamsDTO;

class PrimitiveResolver implements TotalResolver
{

	private OrderReader $orderReader;
	private ItemReader $itemReader;
	private CustomerReader $customerReader;
	private AggregateFactory $aggregateFactory;

	public function __construct(
		OrderReader $orderReader,
		ItemReader $itemReader,
		CustomerReader $customerReader,
		AggregateFactory $aggregateFactory
	) {
		$this->orderReader = $orderReader;
		$this->itemReader = $itemReader;
		$this->customerReader = $customerReader;
		$this->aggregateFactory = $aggregateFactory;
	}


	public function resolve(TotalListRequestParamsDTO $requestParamsDTO): array
	{
		$results = [];

		$aggregatePeriod = $this->aggregateFactory
			->create($requestParamsDTO->getAggregate())
			->resolveAggregatePoints(
				$requestParamsDTO->getDateFrom(), $requestParamsDTO->getDateTo()
			);

		/** @var DateTimeInterface $date */
		foreach ($aggregatePeriod as $date) {
			$periodEnd = $date->add($aggregatePeriod->getDateInterval());

			$orders = $this->orderReader->findAllInDateRange($date, $periodEnd);
			$revenue = $this->calculateRevenue(...$orders);
			$customers = $this->getNewCustomers(...$orders);

			$results[] = new TotalDTO($date, $periodEnd, count($orders), $revenue, $customers);
		}


		return $results;
	}

	private function calculateRevenue(Order ...$orders): float
	{
		$sum = 0;
		foreach ($orders as $order) {
			$items = $this->itemReader->findByOrderId($order->getId());
			foreach ($items as $item) {
				$sum += $item->getPrice() * $item->getQuantity();
			}
		}

		return $sum;
	}

	private function getNewCustomers(Order ...$orders): int
	{
		$customers = 0;
		foreach ($orders as $order) {
			$customer = $this->customerReader->findById($order->getCustomerId());

			if ($customer->getCreatedAt() >= $order->getPurchaseDate()) {
				$customers++;
			}
		}
		return $customers;
	}
}
