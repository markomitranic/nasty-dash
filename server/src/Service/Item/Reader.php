<?php
declare(strict_types=1);

namespace NastyDash\Service\Item;

interface Reader
{

	public function findById(int $id): Item;

	/**
	 * @param int $id
	 * @return Item[]
	 */
	public function findByOrderId(int $id): array;

}
