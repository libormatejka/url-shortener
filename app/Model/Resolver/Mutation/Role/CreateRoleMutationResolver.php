<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Role;

use App\Model\Database\Entity\Role;
use App\Model\Type\InputObjectType\Role\CreateRoleRequest;
use Doctrine\ORM\EntityManagerInterface;

final class CreateRoleMutationResolver implements ICreateRoleMutationResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveCreateRole(CreateRoleRequest $request): Role
	{

		$role = new Role();
		$role->setName( $request->getName() );

		$this->entityManager->persist($role);
		$this->entityManager->flush();
		return $role;

	}

}
