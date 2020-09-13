<?php
declare(strict_types=1);

namespace NastyDash\Service\Item;

class Item
{

	private int $id;

	private string $ean;

	private int $quantity;

	private float $price;

	private int $orderId;

	public function getId(): int
	{
		return $this->id;
	}

	public function getEan(): string
	{
		return $this->ean;
	}

	public function setEan(string $ean): self
	{
		$this->ean = $ean;
		return $this;
	}

	public function getQuantity(): int
	{
		return $this->quantity;
	}

	public function setQuantity(int $quantity): self
	{
		$this->quantity = $quantity;
		return $this;
	}

	public function getPrice(): float
	{
		return $this->price;
	}

	public function setPrice(float $price): self
	{
		$this->price = $price;
		return $this;
	}

	public function getOrderId(): int
	{
		return $this->orderId;
	}

	public function setOrderId(int $orderId): self
	{
		$this->orderId = $orderId;
		return $this;
	}

}
