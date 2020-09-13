<?php
declare(strict_types=1);

namespace NastyDash\Service\Middleware;

use Throwable;

class JsonErrorFormatter extends \Middlewares\ErrorFormatter\JsonFormatter
{

	const HTTP_CONTINUE = 100;
	const HTTP_SUCCESS = 200;
	const HTTP_BAD_REQUEST = 400;
	const HTTP_CLIENT_CLOSED_REQUEST = 499;
	const HTTP_SERVER_ERROR = 500;
	const HTTP_NETWORK_CONNECT_TIMEOUT = 599;
	const CLIENT_ERROR_RANGE_START = self::HTTP_BAD_REQUEST;
	const CLIENT_ERROR_RANGE_END = self::HTTP_CLIENT_CLOSED_REQUEST;
	const HTTP_CODES_RANGE_START = self::HTTP_CONTINUE;
	const HTTP_CODES_RANGE_END = self::HTTP_NETWORK_CONNECT_TIMEOUT;

	protected function errorStatus(Throwable $error): int
	{
		// PDO uses strings
		if (!is_int($error->getCode())) {
			return self::HTTP_SERVER_ERROR;
		}

		if ($this->isClientError($error->getCode())) {
			return self::HTTP_SUCCESS;
		}

		if (!$this->isValidHttpCode($error->getCode())) {
			return self::HTTP_SERVER_ERROR;
		}

		return $error->getCode();
	}

	private function isClientError(int $code): bool {
		if ($code >= self::CLIENT_ERROR_RANGE_START && $code <= self::CLIENT_ERROR_RANGE_END) {
			return true;
		}
		return false;
	}

	private function isValidHttpCode(int $code):bool
	{
		if ($code < self::HTTP_CODES_RANGE_START || $code > self::HTTP_CODES_RANGE_END) {
			return false;
		}
		return true;
	}

}
