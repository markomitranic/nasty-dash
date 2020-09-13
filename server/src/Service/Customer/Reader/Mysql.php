<?php
declare(strict_types=1);

namespace NastyDash\Service\Customer\Reader;

use NastyDash\Service\Customer\Customer;
use NastyDash\Service\Customer\Reader;
use NastyDash\Service\Database\PDO;
use PDOStatement;

class Mysql implements Reader
{

	const FIND_BY_ID_TEMPLATE = "SELECT * FROM `customer` WHERE `id`=:id;";
	const FIND_ALL_TEMPLATE = "SELECT * FROM `customer`;";

	private PDO $pdo;
	private PDOStatement $findByIdStatement;
	private PDOStatement $findAllStatement;

	public function __construct(
		PDO $pdo
	) {
		$this->pdo = $pdo;
		$this->findByIdStatement = $pdo->prepare(self::FIND_BY_ID_TEMPLATE);
		$this->findByIdStatement->setFetchMode(PDO::FETCH_CLASS, Customer::class);
		$this->findAllStatement = $pdo->prepare(self::FIND_ALL_TEMPLATE);
		$this->findAllStatement->setFetchMode(PDO::FETCH_CLASS, Customer::class);
	}

	public function findById(int $id): Customer
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
