<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Roles;

use App\Model\Database\Entity\Role;
use App\Model\Type\InputObjectType\Roles\RolesFilterRequest;
use Doctrine\ORM\EntityManagerInterface;

final class RolesQueryResolver implements IRolesQueryResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @return array<int, Role>
	 */
	public function resolveRoles(RolesFilterRequest $request): array
	{

		$query = $this->entityManager->createQueryBuilder()
			->select('r')
			->from(Role::class, 'r');

		if($request->getName() !== null) {
			$query
				->andWhere('r.name = :name')
				->setParameter(':name', $request->getName());
		}

		return $query->getQuery()->getResult();
	}

}
