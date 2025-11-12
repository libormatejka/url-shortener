<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\User;

use DateTime;

final class UpdateUserRequest
{

	public string $firstname;
	public string $lastname;
	public string $username;
	public string $email;
	public string $password;
	public DateTime $createdAt;
	public int $roleId;

	public function getFirstName(): string
	{
		return $this->firstname;
	}

	public function setFirstName(string $firstname): void
	{
		$this->firstname = $firstname;
	}

	public function getLastName(): string
	{
		return $this->lastname;
	}

	public function setLastName(string $lastname): void
	{
		$this->lastname = $lastname;
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function setUsername(string $username): void
	{
		$this->username = $username;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	public function getCreatedAt(): ?DateTime
	{
		return $this->createdAt;
	}

	public function setCreatedAt(?DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
	}

	public function getRoleId(): int
	{
		return $this->roleId;
	}

	public function setRoleId(int $roleId): void
	{
		$this->roleId = $roleId;
	}

	/**
	 * @param array{
	 * firstname:string,
	 * lastname:string,
	 * email: string,
	 * password: string,
	 * username: string,
	 * roleId: int
	 * } $data
	 */
	public static function fromArray(array $data): UpdateUserRequest
	{
		$request = new UpdateUserRequest();
		$request->setFirstName($data['firstname']);
		$request->setLastName($data['lastname']);
		$request->setUsername($data['username']);
		$request->setEmail($data['email']);
		$request->setPassword($data['password']);
		$request->setCreatedAt(new DateTime());
		$request->setRoleId($data['roleId']);

		return $request;
	}

}
