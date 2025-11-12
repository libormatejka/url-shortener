<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Users;

use App\Model\Database\Entity\User;
use App\Model\Type\InputObjectType\Users\UsersFilterRequest;
use Doctrine\ORM\EntityManagerInterface;

final class UsersQueryResolver implements IUsersQueryResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @return array<int, User>
	 */
	public function resolveUsers(UsersFilterRequest $request): array
	{

		$query = $this->entityManager->createQueryBuilder()
			->select('u')
			->from(User::class, 'u');

		if($request->getLimit() !== null) {
			$query
				->setMaxResults( $request->getLimit() );
		}

		if($request->getOffset() !== null) {
			$query
				->setFirstResult( $request->getOffset() );
		}

		if($request->getUsername() !== null) {

			$query->andWhere('u.username = :username')
				->setParameter(':username', $request->getUsername());
		}

		if($request->getEmail() !== null) {

			$query->andWhere('u.email = :email')
				->setParameter(':email', $request->getEmail());
		}

		if($request->getNotId() !== null) {

			$query->andWhere('u.id != :id')
				->setParameter(':id', $request->getNotId());
		}

		if($request->getRoleId() !== null) {

			$query->andWhere('u.role = :roleId')
				->setParameter(':roleId', $request->getRoleId());
		}

		return $query->getQuery()->getResult();
	}

}
