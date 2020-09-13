<?php
declare(strict_types=1);

namespace NastyDash\Service\Customer;

interface Saver
{

	public function insert(Customer $customer): Customer;

}
