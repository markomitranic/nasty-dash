<?php
declare(strict_types=1);

namespace NastyDash\Service\Customer\Saver;

use NastyDash\Service\Customer\Customer;
use NastyDash\Service\Customer\Reader;
use NastyDash\Service\Customer\Saver;
use NastyDash\Service\Database\PDO;
use PDOStatement;

class Mysql implements Saver
{

	const INSERT_STATEMENT_TEMPLATE = "INSERT INTO `customer` (`first_name`, `last_name`, `email`) VALUES (:first_name, :last_name, :email);";

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

	public function insert(Customer $customer): Customer
	{
		$parameters = [
			'first_name' => $customer->getFirstName(),
			'last_name' => $customer->getLastName(),
			'email' => $customer->getEmail()
		];

		$this->insertStatement->execute($parameters);
		return $this->reader->findById((int) $this->pdo->lastInsertId());
	}
}
