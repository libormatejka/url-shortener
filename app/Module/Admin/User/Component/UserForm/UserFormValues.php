<?php declare(strict_types = 1);

namespace App\Module\Admin\User\Component\UserForm;

use Nette\Application\UI\Control;
use Nette\Security\Passwords;

final class UserFormValues extends Control
{

	public string $firstname;
	public string $lastname;
	public string $username;
	public string $email;
	public string $password;
	public int $role;

	/**
	 * @return array{
	 * firstname:string,
	 * lastname:string,
	 * email: string,
	 * password: string,
	 * username: string,
	 * role: int,
	 * }
	 */
	public function toArray(): array
	{
		$passwords = new Passwords();

		if( $this->password == ''){

		}

		return [
			"firstname" => $this->firstname,
			"lastname" => $this->lastname,
			"username" => $this->username,
			"email" => $this->email,
			"password" => $passwords->hash($this->password),
			"role" => $this->role,
		];
	}

}
