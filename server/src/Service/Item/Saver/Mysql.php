<?php
declare(strict_types=1);

namespace NastyDash\Service\Item\Saver;

use NastyDash\Service\Database\PDO;
use NastyDash\Service\Item\Item;
use NastyDash\Service\Item\Reader;
use NastyDash\Service\Item\Saver;
use PDOStatement;

class Mysql implements Saver
{

	const INSERT_STATEMENT_TEMPLATE = "INSERT INTO `item` (`ean`, `quantity`, `price`, `order_id`) VALUES (:ean, :quantity, :price, :order_id);";

	private PDO $pdo;
	private PDOStatement $insertStatement;
	private Reader $reader;

	public function __construct(
		PDO $pdo,
		Reader $reader
	) {
		$this->pdo = $pdo;
		$this->reader = $reader;
		$this->insertStatement = $this->pdo->prepare(self::INSERT_STATEMENT_TEMPLATE);
	}

	public function insert(Item $item): Item
	{
		$parameters = [
			'ean' => $item->getEan(),
			'quantity' => $item->getQuantity(),
			'price' => $item->getPrice(),
			'order_id' => $item->getOrderId()
		];

		$this->insertStatement->execute($parameters);
		return $this->reader->findById((int) $this->pdo->lastInsertId());
	}
}
