<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats\TotalResolver;

use DatePeriod;
use DateTimeInterface;
use NastyDash\Service\Customer\Reader as CustomerReader;
use NastyDash\Service\Item\Reader as ItemReader;
use NastyDash\Service\Order\Order;
use NastyDash\Service\Order\Reader as OrderReader;
use NastyDash\Service\Stats\TotalDTO;

class PrimitiveResolver implements TotalResolver
{

	private OrderReader $orderReader;
	private ItemReader $itemReader;
	private CustomerReader $customerReader;

	public function __construct(
		OrderReader $orderReader,
		ItemReader $itemReader,
		CustomerReader $customerReader
	) {
		$this->orderReader = $orderReader;
		$this->itemReader = $itemReader;
		$this->customerReader = $customerReader;
	}


	public function resolve(DatePeriod $aggregatePeriod): array
	{
		$results = [];

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
