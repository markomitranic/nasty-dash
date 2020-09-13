<?php
declare(strict_types=1);

namespace NastyDash\Service\Order;

interface Reader
{

	public function findById(int $id): Order;

}
