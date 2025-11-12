<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Urls;

use App\Model\Database\Entity\Url;
use App\Model\Type\InputObjectType\Urls\UrlsFilterRequest;
use Doctrine\ORM\EntityManagerInterface;

final class UrlsQueryResolver implements IUrlsQueryResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @return array<int, Url>
	 */
	public function resolveUrls(UrlsFilterRequest $request): array
	{

		$query = $this->entityManager->createQueryBuilder()
			->select('u')
			->from(Url::class, 'u');

		if($request->getCategoryId() !== null) {
			$query
				->innerJoin('u.category', 'c')
				->where('c.id = :categoryId')
				->setParameter(':categoryId', $request->getCategoryId());
		}

		if($request->getUserId() !== null) {
			$query
				->innerJoin('u.user', 'us')
				->andWhere('us.id = :userId')
				->setParameter(':userId', $request->getUserId());
		}

		if($request->getSourceUrl() !== null) {
			$query
				->andWhere('u.sourceUrl = :sourceUrl')
				->setParameter(':sourceUrl', $request->getSourceUrl());
		}

		if($request->getLimit() !== null) {
			$query
				->setMaxResults( $request->getLimit() );

		}

		if($request->getOffset() !== null) {
			$query
				->setFirstResult( $request->getOffset() );
		}

		if($request->getNotId() !== null) {

			$query->andWhere('u.id != :id')
				->setParameter(':id', $request->getNotId());
		}

		return $query->getQuery()->getResult();
	}

	/**
	 * @return array<int, Url>
	 */
	public function resolveCountUrls(UrlsFilterRequest $request): array
	{

		$query = $this->entityManager->createQueryBuilder()
			->select('u')
			->from(Url::class, 'u');

		return $query->getQuery()->getSingleScalarResult();
	}

	public function resolveSumUrl(UrlsFilterRequest $request): ?string
	{
		$query = $this->entityManager->createQueryBuilder()
			->select('sum(u.counter)')
			->from(Url::class, 'u');

		if($request->getUserId() !== null) {
			$query->where('u.user = :userId')
				->setParameter(':userId', $request->getUserId());
		}

		return $query->getQuery()->getSingleScalarResult();
	}

}
