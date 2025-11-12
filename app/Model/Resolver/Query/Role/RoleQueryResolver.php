<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Role;

use App\Model\Database\Entity\Role;
use App\Model\Type\InputObjectType\Role\RoleFilterRequest;
use Doctrine\ORM\EntityManagerInterface;

final class RoleQueryResolver implements IRoleQueryResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveRole(RoleFilterRequest $request): ?Role
	{

		$query = $this->entityManager->createQueryBuilder()
			->select('r')
			->from(Role::class, 'r');

		if($request->getId() !== null) {
			$query->andWhere('r.id = :roleId')
				->setParameter(':roleId', $request->getId());
		}

		return $query->getQuery()->getOneOrNullResult();
	}

}
