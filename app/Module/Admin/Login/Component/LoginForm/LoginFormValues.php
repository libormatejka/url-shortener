<?php declare(strict_types = 1);

namespace App\Module\Admin\Login\Component\LoginForm;

use Nette\Application\UI\Control;

final class LoginFormValues extends Control
{

	public string $email;

	public string $password;

	/**
	 * @return array{email: string, password: string}
	 */
	public function toArray(): array
	{
		return ["email" => $this->email, "password" => $this->password];
	}

}
