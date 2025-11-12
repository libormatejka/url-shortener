<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Role;

use App\Model\Database\Entity\Role;
use App\Model\Type\InputObjectType\Role\UpdateRoleRequest;
use Doctrine\ORM\EntityManagerInterface;

final class UpdateRoleMutationResolver implements IUpdateRoleMutationResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveUpdateRole(Role $role, UpdateRoleRequest $request): Role
	{
		$role->setName( $request->getName() );
		$this->entityManager->flush();

		return $role;
	}

}
