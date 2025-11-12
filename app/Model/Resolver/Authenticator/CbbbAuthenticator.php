<?php declare(strict_types = 1);

namespace App\Model\Resolver\Authenticator;

use App\Model\Resolver\Query\User\IUserQueryResolver;
use App\Model\Type\InputObjectType\User\UserFilterRequest;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;

class CbbbAuthenticator implements Authenticator
{

	private IUserQueryResolver $userQueryResolver;
	private Passwords $passwords;

	public function __construct(
		Passwords $passwords,
		IUserQueryResolver $userQueryResolver,
	)
	{
		$this->passwords = $passwords;
		$this->userQueryResolver = $userQueryResolver;
	}

	public function authenticate(string $username, string $password): IIdentity
	{
		$request = new UserFilterRequest();
		$request->setEmail( $username );
		$request->setMaxResults( 1 );

		$row = $this->userQueryResolver->resolveUser($request);

		if (!$row) {
			throw new AuthenticationException('User not found.');
		}

		if (!$this->passwords->verify($password, $row->getPassword())) {
			throw new AuthenticationException('Invalid password.');
		}

		return new SimpleIdentity(
			$row->getId(),
			$row->getRole()->getName(),
			[
				'id' => $row->getId(),
				'firstname' => $row->getFirstname(),
				'lastname' => $row->getLastname(),
				'username' => $row->getUsername(),
				'email' => $row->getEmail(),
			],
		);
	}

}
