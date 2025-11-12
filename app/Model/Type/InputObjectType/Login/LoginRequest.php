<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Login;

final class LoginRequest
{

	private string $email;
	private string $password;

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

	/**
	 * @param array{email: string,password: string} $data
	 */
	public static function fromArray(array $data): LoginRequest
	{
		$request = new LoginRequest();
		$request->setEmail($data['email']);
		$request->setPassword($data['password']);

		return $request;
	}

}
