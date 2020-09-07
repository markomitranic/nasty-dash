<?php
declare(strict_types=1);

namespace NastyDash\Service\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Orders extends Controller
{

	public function __invoke(RequestInterface $request): ResponseInterface
	{
		$this->logger->critical('hehe');
		$data = ['trie' => true];
		return new Response(200, [], json_encode($data, JSON_THROW_ON_ERROR));
	}
}
