<?php
declare(strict_types=1);

namespace NastyDash\Service\Controller\Stats;

use NastyDash\Service\Controller\Controller;
use NastyDash\Service\Stats\TotalAggregateService;
use NastyDash\Service\Stats\TotalListRequestValidator;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class Total extends Controller
{

	private TotalListRequestValidator $listRequestValidator;
	private TotalAggregateService $aggregateService;

	public function __construct(
		TotalListRequestValidator $listRequestValidator,
		TotalAggregateService $aggregateService,
		LoggerInterface $logger
	) {
		$this->listRequestValidator = $listRequestValidator;
		$this->aggregateService = $aggregateService;
		parent::__construct($logger);
	}

	public function __invoke(ServerRequestInterface $request): ResponseInterface
	{
		$this->logRequest($request);

		$listRequestDto = $this->listRequestValidator->transform($request);
		$data = $this->aggregateService->getAggregate($listRequestDto);

		return new Response(200, [], json_encode(['data' => $data], JSON_THROW_ON_ERROR));
	}
}
