<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\User;

final class UserFilterRequest
{

	private ?int $id = null;
	private ?string $username = null;
	private ?string $email = null;
	private ?string $password = null;
	private ?string $firstname = null;
	private ?string $lastname = null;
	private int $maxResults = 0;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): void
	{
		$this->id = $id;
	}

	public function getUsername(): ?string
	{
		return $this->username;
	}

	public function setUsername(?string $username): void
	{
		$this->username = $username;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(?string $email): void
	{
		$this->email = $email;
	}

	public function getPassword(): ?string
	{
		return $this->password;
	}

	public function setPassword(?string $password): void
	{
		$this->password = $password;
	}

	public function getFirstname(): ?string
	{
		return $this->firstname;
	}

	public function setFirstname(?string $firstname): void
	{
		$this->firstname = $firstname;
	}

	public function getLastname(): ?string
	{
		return $this->lastname;
	}

	public function setLastname(?string $lastname): void
	{
		$this->lastname = $lastname;
	}

	public function getMaxResults(): int
	{
		return $this->maxResults;
	}

	public function setMaxResults(int $maxResults): void
	{
		$this->maxResults = $maxResults;
	}

}
