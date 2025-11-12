<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Login;

use App\Model\Type\InputObjectType\Login\LoginRequest;
use Doctrine\ORM\EntityManagerInterface;
use Nette\Security\User as SecurityUser;

final class LoginMutationResolver implements ILoginMutationResolver
{

	private EntityManagerInterface $entityManager;
	private SecurityUser $securityUser;

	public function __construct(EntityManagerInterface $entityManager, SecurityUser $securityUser)
	{
		$this->entityManager = $entityManager;
		$this->securityUser = $securityUser;
	}

	public function resolveLogin(LoginRequest $request): bool
	{
		//$this->securityUser->setAuthenticator($this->authenticator);
		$this->securityUser->login($request->getEmail(), $request->getPassword());
		return true;
	}

}
