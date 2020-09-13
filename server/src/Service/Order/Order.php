<?php

declare(strict_types=1);

namespace NastyDash\Service\Order;

use DateTime;

class Order
{

	private int $id;

	private DateTime $purchaseDate;

	private string $country;

	private string $device;

	private int $customerId;

	public function getId(): int
	{
		return $this->id;
	}

	public function getPurchaseDate(): DateTime
	{
		return $this->purchaseDate;
	}

	public function setPurchaseDate(DateTime $purchaseDate): self
	{
		$this->purchaseDate = $purchaseDate;
		return $this;
	}

	public function getCountry(): string
	{
		return $this->country;
	}

	public function setCountry(string $country): self
	{
		$this->country = $country;
		return $this;
	}

	public function getDevice(): string
	{
		return $this->device;
	}

	public function setDevice(string $device): self
	{
		$this->device = $device;
		return $this;
	}

	public function getCustomerId(): int
	{
		return $this->customerId;
	}

	public function setCustomerId(int $customerId): self
	{
		$this->customerId = $customerId;
		return $this;
	}
}
