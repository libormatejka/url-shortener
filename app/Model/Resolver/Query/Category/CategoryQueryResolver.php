<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Category;

use App\Model\Database\Entity\Category;
use App\Model\Type\InputObjectType\Category\CategoryRequest;
use Doctrine\ORM\EntityManagerInterface;

final class CategoryQueryResolver implements ICategoryQueryResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveCategory(CategoryRequest $request): ?Category
	{

		$query = $this->entityManager->createQueryBuilder()
			->select('c')
			->from(Category::class, 'c')
			->leftJoin('c.urls', 'u');

		if($request->getId() !== null) {
			$query->andWhere('c.id = :categoryId')
				->setParameter(':categoryId', $request->getId());
		}

		if($request->getUserId() !== null) {
			$query
				->innerJoin('c.user', 'us')
				->andWhere('us.id = :userId')
				->setParameter(':userId', $request->getUserId());
		}

		return $query->getQuery()->getOneOrNullResult();
	}

}
