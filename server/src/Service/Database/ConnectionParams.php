<?php
declare(strict_types=1);

namespace NastyDash\Service\Database;

class ConnectionParams
{

	const DEFAULT_CHARSET = 'utf8mb4';

	private string $host;
	private string $database;
	private string $user;
	private string $password;
	private string $charset;

	public function __construct(
		string $host,
		string $database,
		string $user,
		string $password,
		string $charset = self::DEFAULT_CHARSET
	) {
		$this->host = $host;
		$this->database = $database;
		$this->user = $user;
		$this->password = $password;
		$this->charset = $charset;
	}

	public function getHost(): string
	{
		return $this->host;
	}

	public function getDatabase(): string
	{
		return $this->database;
	}

	public function getUser(): string
	{
		return $this->user;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function getCharset(): string
	{
		return $this->charset;
	}

}
