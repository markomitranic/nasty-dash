<?php
declare(strict_types=1);

namespace NastyDash\Service\Controller;

use Faker\Factory;
use Faker\Generator;
use NastyDash\Service\Customer\Customer;
use NastyDash\Service\Customer\Saver as CustomerSaver;
use NastyDash\Service\Item\Item;
use NastyDash\Service\Item\Saver as ItemSaver;
use NastyDash\Service\Order\Order;
use NastyDash\Service\Order\Saver as OrderSaver;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class Seed extends Controller
{

	private CustomerSaver $customerSaver;
	private OrderSaver $orderSaver;
	private ItemSaver $itemSaver;
	private Generator $faker;

	public function __construct(
		CustomerSaver $customerSaver,
		OrderSaver $orderSaver,
		ItemSaver $itemSaver,
		LoggerInterface $logger
	) {
		$this->customerSaver = $customerSaver;
		$this->orderSaver = $orderSaver;
		$this->itemSaver = $itemSaver;
		$this->faker = Factory::create();
		parent::__construct($logger);
	}

	public function __invoke(ServerRequestInterface $request): ResponseInterface
	{
		$this->logRequest($request);

		/** @var Customer[] $customers */
		$customers = [];
		for ($i=0; $i < 1000; $i++) {
			$customer = (new Customer())
				->setEmail($this->faker->email)
				->setFirstName($this->faker->name)
				->setLastName($this->faker->lastName);

			$customers[] = $this->customerSaver->insert($customer);
		}

		/** @var Order[] $orders */
		$orders = [];
		foreach ($customers as $customer) {
			for ($i=0; $i < rand(1, 7); $i++) {
				$order = (new Order())
					->setCustomerId($customer->getId())
					->setCountry($this->faker->country)
					->setDevice('mobile')
					->setPurchaseDate($this->faker->dateTimeBetween('-2 years', 'now'));

				$orders[] = $this->orderSaver->insert($order);
			}
		}

		/** @var Item[] $items */
		$items = [];
		foreach ($orders as $order) {
			for ($i=0; $i < rand(1, 7); $i++) {
				$item = (new Item())
					->setPrice($this->faker->randomFloat(2, 1, 1000))
					->setOrderId($order->getId())
					->setQuantity($this->faker->numberBetween(1, 12))
					->setEan($this->faker->ean8);

				$items[] = $this->itemSaver->insert($item);
			}
		}

		$output = [
			'customers' => count($customers),
			'orders' => count($orders),
			'items' => count($items)
		];

		return new Response(200, [], json_encode(['data' => $output], JSON_THROW_ON_ERROR));
	}

}
