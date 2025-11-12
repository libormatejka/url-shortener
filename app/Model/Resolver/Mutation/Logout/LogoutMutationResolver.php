<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Logout;

use Nette\Security\User as SecurityUser;

final class LogoutMutationResolver
{

	private SecurityUser $securityUser;

	public function __construct(SecurityUser $securityUser)
	{
		$this->securityUser = $securityUser;
	}

	public function resolveLogout(): bool
	{
		$this->securityUser->logout();
		return true;
	}

}
