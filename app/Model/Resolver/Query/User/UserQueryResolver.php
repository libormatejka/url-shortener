<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\User;

use App\Model\Database\Entity\User;
use App\Model\Type\InputObjectType\User\UserFilterRequest;
use Doctrine\ORM\EntityManagerInterface;

final class UserQueryResolver implements IUserQueryResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveUser(UserFilterRequest $request): ?User
	{

		$query = $this->entityManager->createQueryBuilder()
			->select('u')
			->from(User::class, 'u');

		if($request->getId() !== null) {
			$query->andWhere('u.id = :userId')
				->setParameter(':userId', $request->getId());
		}

		if($request->getUsername() !== null) {

			$query->andWhere('u.username = :username')
				->setParameter(':username', $request->getUsername());
		}

		if($request->getEmail() !== null) {

			$query->andWhere('u.email = :email')
				->setParameter(':email', $request->getEmail());
		}

		if($request->getPassword() !== null) {

			$query->andWhere('u.password = :password')
				->setParameter(':password', $request->getPassword());
		}

		if($request->getFirstname() !== null) {

			$query->andWhere('u.firstname = :firstname')
				->setParameter(':firstname', $request->getFirstname());
		}

		if($request->getLastname() !== null) {

			$query->andWhere('u.lastname = :lastname')
				->setParameter(':lastname', $request->getLastname());
		}

		if($request->getMaxResults() !== 0) {
			$query->setMaxResults($request->getMaxResults());
		}

		return $query->getQuery()->getOneOrNullResult();
	}

}
