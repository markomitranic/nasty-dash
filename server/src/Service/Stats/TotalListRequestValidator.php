<?php
declare(strict_types=1);

namespace NastyDash\Service\Stats;

use DateTimeImmutable;
use NastyDash\Service\Stats\DateRange\AggregateFactory;
use Psr\Http\Message\ServerRequestInterface;

class TotalListRequestValidator
{

	const ALLOWED_AGGREGATE = [
		AggregateFactory::AGGREGATE_HOUR,
		AggregateFactory::AGGREGATE_DAY,
		AggregateFactory::AGGREGATE_MONTH,
		AggregateFactory::AGGREGATE_YEAR
	];

	public function transform(ServerRequestInterface $request): TotalListRequestParamsDTO
	{
		if (array_key_exists('dateFrom', $request->getQueryParams())) {
			$dateFrom = DateTimeImmutable::createFromFormat('U', $request->getQueryParams()['dateFrom']);
		} else {
			$dateFrom = new DateTimeImmutable('-30 days');
		}

		if (array_key_exists('dateTo', $request->getQueryParams())) {
			$dateTo = DateTimeImmutable::createFromFormat('U', $request->getQueryParams()['dateTo']);
		} else {
			$dateTo = new DateTimeImmutable('now');
		}

		if (array_key_exists('aggregate', $request->getQueryParams())) {
			if (!in_array($request->getQueryParams()['aggregate'], self::ALLOWED_AGGREGATE)) {
				throw new \Exception(
					sprintf('Provided aggregation period is not valid: %s', $request->getQueryParams()['aggregate']),
					400
				);
			}
			$aggregate = $request->getQueryParams()['aggregate'];
		} else {
			$aggregate = AggregateFactory::AGGREGATE_DAY;
		}

		return new TotalListRequestParamsDTO($aggregate, $dateFrom, $dateTo);
	}


}
