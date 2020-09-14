<?php
declare(strict_types=1);

namespace NastyDash\Service\Item\Reader;

use NastyDash\Service\Database\PDO;
use NastyDash\Service\Item\Item;
use NastyDash\Service\Item\Reader;
use PDOStatement;

class Mysql implements Reader
{

	const FIND_BY_ID_TEMPLATE = "SELECT * FROM `item` WHERE `id`=:id;";
	const FIND_ALL_TEMPLATE = "SELECT * FROM `item`;";
	const FIND_ALL_BY_ORDER_TEMPLATE = "SELECT * FROM `item` WHERE `order_id`=:id;";

	private PDO $pdo;
	private PDOStatement $findByIdStatement;
	private PDOStatement $findAllStatement;
	private PDOStatement $findAllByOrderStatement;

	public function __construct(
		PDO $pdo
	) {
		$this->pdo = $pdo;
		$this->findByIdStatement = $pdo->prepare(self::FIND_BY_ID_TEMPLATE);
		$this->findByIdStatement->setFetchMode(PDO::FETCH_CLASS, Item::class);
		$this->findAllStatement = $pdo->prepare(self::FIND_ALL_TEMPLATE);
		$this->findAllStatement->setFetchMode(PDO::FETCH_CLASS, Item::class);
		$this->findAllByOrderStatement = $pdo->prepare(self::FIND_ALL_BY_ORDER_TEMPLATE);
		$this->findAllByOrderStatement->setFetchMode(PDO::FETCH_CLASS, Item::class);
	}

	public function findById(int $id): Item
	{
		$this->findByIdStatement->execute(['id' => $id]);
		return $this->findByIdStatement->fetch();
	}

	public function findAll(): array
	{
		$this->findAllStatement->execute();
		return $this->findAllStatement->fetchAll();
	}

	public function findByOrderId(int $id): array
	{
		$this->findAllByOrderStatement->execute(['id' => $id]);
		return $this->findAllByOrderStatement->fetchAll();
	}
}
