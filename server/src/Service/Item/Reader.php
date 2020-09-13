<?php
declare(strict_types=1);

namespace NastyDash\Service\Item;

interface Reader
{

	public function findById(int $id): Item;

}
