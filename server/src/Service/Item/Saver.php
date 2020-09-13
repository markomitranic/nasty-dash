<?php
declare(strict_types=1);

namespace NastyDash\Service\Item;

interface Saver
{

	public function insert(Item $item): Item;

}
