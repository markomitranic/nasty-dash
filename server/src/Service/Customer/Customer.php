<?php
declare(strict_types=1);

namespace NastyDash\Service\Customer;

class Customer
{

	private int $id;

	private string $firstName;

	private string $lastName;

	private string $email;

	public function getId(): int
	{
		return $this->id;
	}

	public function getFirstName(): string
	{
		return $this->firstName;
	}

	public function setFirstName(string $firstName): self
	{
		$this->firstName = $firstName;
		return $this;
	}

	public function getLastName(): string
	{
		return $this->lastName;
	}

	public function setLastName(string $lastName): self
	{
		$this->lastName = $lastName;
		return $this;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;
		return $this;
	}

}
