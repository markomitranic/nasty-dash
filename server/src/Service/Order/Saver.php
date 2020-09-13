<?php
declare(strict_types=1);

namespace NastyDash\Service\Order;

interface Saver
{

	public function insert(Order $order): Order;

}
