<?php
declare(strict_types=1);

namespace NastyDash\Service\Order\Reader;

use DateTimeInterface;
use NastyDash\Service\Database\PDO;
use NastyDash\Service\Order\Order;
use NastyDash\Service\Order\Reader;
use PDOStatement;

class Mysql implements Reader
{

	const FIND_BY_ID_TEMPLATE = "SELECT * FROM `order` WHERE `id`=:id;";
	const FIND_ALL_TEMPLATE = "SELECT * FROM `order`;";
	const FIND_ALL_DATE_RANGE_TEMPLATE = "SELECT * FROM `order` WHERE `purchase_date` > :dateFrom AND `purchase_date` < :dateTo;";

	private PDO $pdo;
	private PDOStatement $findByIdStatement;
	private PDOStatement $findAllStatement;
	private PDOStatement $findAllInDateRangeStatement;

	public function __construct(
		PDO $pdo
	) {
		$this->pdo = $pdo;
		$this->findByIdStatement = $pdo->prepare(self::FIND_BY_ID_TEMPLATE);
		$this->findByIdStatement->setFetchMode(PDO::FETCH_CLASS, Order::class);
		$this->findAllStatement = $pdo->prepare(self::FIND_ALL_TEMPLATE);
		$this->findAllStatement->setFetchMode(PDO::FETCH_CLASS, Order::class);
		$this->findAllInDateRangeStatement = $pdo->prepare(self::FIND_ALL_DATE_RANGE_TEMPLATE);
		$this->findAllInDateRangeStatement->setFetchMode(PDO::FETCH_CLASS, Order::class);
	}

	public function findById(int $id): Order
	{
		$this->findByIdStatement->execute(['id' => $id]);
		return $this->findByIdStatement->fetch();
	}

	public function findAll(): array
	{
		$this->findAllStatement->execute();
		return $this->findAllStatement->fetchAll();
	}

	public function findAllInDateRange(DateTimeInterface $from, DateTimeInterface $to): array
	{
		$params = [
			'dateFrom' => $from->format("Y-m-d H:i:s"),
			'dateTo' => $to->format("Y-m-d H:i:s")
		];
		$this->findAllInDateRangeStatement->execute($params);
		return $this->findAllInDateRangeStatement->fetchAll();
	}
}
