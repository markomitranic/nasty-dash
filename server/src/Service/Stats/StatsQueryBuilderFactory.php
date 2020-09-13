<?php

declare(strict_types=1);


namespace NastyDash\Service\Stats;


class StatsQueryBuilderFactory
{

	public static function createFromRequestParams(BannerListRequestParamsDTO $filterParams)
	{
		$decorator = new BaseDecorator(
			$documentManager->createQueryBuilder('AskGamblersCoreBundle:Banner')
		);



		$decorator = new SortDecorator($decorator, $filterParams);
		$decorator = new SkipLimitDecorator($decorator, $filterParams);

		return $decorator->getBuilder();
	}

}
