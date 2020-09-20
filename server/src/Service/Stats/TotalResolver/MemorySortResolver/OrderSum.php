<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats\TotalResolver\MemorySortResolver;

class OrderSum
{

	private string $purchase_date;
	private bool $newCustomer;
	private float $itemTotalPrice;

	public function getPurchaseDate(): string
	{
		return $this->purchase_date;
	}

	public function getNewCustomer(): bool
	{
		return $this->newCustomer;
	}

	public function getItemTotalPrice(): float
	{
		return $this->itemTotalPrice;
	}

}
