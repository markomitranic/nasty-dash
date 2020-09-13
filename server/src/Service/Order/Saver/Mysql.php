<?php

declare(strict_types=1);

namespace NastyDash\Service\Order\Saver;

use NastyDash\Service\Database\PDO;
use NastyDash\Service\Order\Order;
use NastyDash\Service\Order\Reader;
use NastyDash\Service\Order\Saver;
use PDOStatement;

class Mysql implements Saver
{

	const INSERT_STATEMENT_TEMPLATE = "INSERT INTO `order` (`purchase_date`, `country`, `device`, `customer_id`) VALUES (:purchase_date, :country, :device, :customer_id);";

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

	public function insert(Order $order): Order
	{
		$parameters = [
			'purchase_date' => $order->getPurchaseDate()->format("Y-m-d H:i:s"),
			'country' => $order->getCountry(),
			'device' => $order->getDevice(),
			'customer_id' => $order->getCustomerId()
		];

		$this->insertStatement->execute($parameters);
		return $this->reader->findById((int) $this->pdo->lastInsertId());
	}
}
