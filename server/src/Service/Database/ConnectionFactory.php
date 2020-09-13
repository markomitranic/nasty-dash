<?php
declare(strict_types=1);

namespace NastyDash\Service\Database;

class ConnectionFactory
{

	const DSN_PATTERN = 'mysql:host=%s;dbname=%s;charset=%s';

	public function __invoke(ConnectionParams $connectionParams): PDO {
		$pdo = new PDO(
			self::generateDsn($connectionParams),
			$connectionParams->getUser(),
			$connectionParams->getPassword()
		);

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

		return $pdo;
	}

	public static function generateDsn(ConnectionParams $connectionParams): string
	{
		return sprintf(
			self::DSN_PATTERN,
			$connectionParams->getHost(),
			$connectionParams->getDatabase(),
			$connectionParams->getCharset()
		);
	}

}
