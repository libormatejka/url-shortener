<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Categories;

use App\Model\Database\Entity\Category;
use App\Model\Type\InputObjectType\Category\CategoryRequest;
use Doctrine\ORM\EntityManagerInterface;

final class CategoriesQueryResolver implements ICategoriesQueryResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @return array<int, Category>
	 */
	public function resolveCategories(CategoryRequest $request): array
	{

		$query = $this->entityManager->createQueryBuilder()
			->select('c')
			->from(Category::class, 'c');

		if($request->getLimit() !== null) {
			$query
				->setMaxResults( $request->getLimit() );

		}

		if($request->getOffset() !== null) {
			$query
				->setFirstResult( $request->getOffset() );
		}

		if($request->getUserId() !== null) {
			$query
				->innerJoin('c.user', 'us')
				->andWhere('us.id = :userId')
				->setParameter(':userId', $request->getUserId());
		}

		if($request->getSlug() !== null) {
			$query
				->andWhere('c.slug = :slug')
				->setParameter(':slug', $request->getSlug());
		}

		return $query->getQuery()->getResult();
	}

}
