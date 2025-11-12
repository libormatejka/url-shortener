<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Role;

use App\Model\Database\Entity\Role;
use App\Model\Type\InputObjectType\Role\RemoveRoleFilterRequest;
use Nettrine\ORM\EntityManagerDecorator;

final class RemoveRoleMutationResolver implements IRemoveRoleMutationResolver
{

	private EntityManagerDecorator $entityManager;

	public function __construct(EntityManagerDecorator $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveRemoveRole(RemoveRoleFilterRequest $request): void
	{

		$category = $this->entityManager->getRepository(Role::class)->find($request->getId());
		if($category !== null)
		{
			$this->entityManager->remove($category);
			$this->entityManager->flush();
		}

	}

}
