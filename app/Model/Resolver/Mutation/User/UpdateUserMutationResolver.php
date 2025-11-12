<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\User;

use App\Model\Database\Entity\Role;
use App\Model\Database\Entity\User;
use App\Model\Type\InputObjectType\User\UpdateUserRequest;
use Nettrine\ORM\EntityManagerDecorator;

final class UpdateUserMutationResolver implements IUpdateUserMutationResolver
{

	private EntityManagerDecorator $entityManager;

	public function __construct(EntityManagerDecorator $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveUpdateUser(User $url, UpdateUserRequest $request): User
	{
		$url->setFirstName( $request->getFirstName() );
		$url->setLastName( $request->getLastName() );
		$url->setEmail( $request->getEmail() );
		$url->setPassword( $request->getPassword() );
		$url->setUsername( $request->getUsername() );

		$role = $this->entityManager->getRepository(Role::class)->find($request->getRoleId());
		$url->setRole($role);

		$this->entityManager->flush();

		return $url;
	}

}
