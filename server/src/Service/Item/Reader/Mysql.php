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

	private PDO $pdo;
	private PDOStatement $findByIdStatement;
	private PDOStatement $findAllStatement;

	public function __construct(
		PDO $pdo
	) {
		$this->pdo = $pdo;
		$this->findByIdStatement = $pdo->prepare(self::FIND_BY_ID_TEMPLATE);
		$this->findByIdStatement->setFetchMode(PDO::FETCH_CLASS, Item::class);
		$this->findAllStatement = $pdo->prepare(self::FIND_ALL_TEMPLATE);
		$this->findAllStatement->setFetchMode(PDO::FETCH_CLASS, Item::class);
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
}
