<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Url;

use App\Model\Database\Entity\Url;
use App\Model\Type\InputObjectType\Url\UrlFilterRequest;
use Doctrine\ORM\EntityManagerInterface;

final class UrlQueryResolver implements IUrlQueryResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveUrl(UrlFilterRequest $request): ?Url
	{

		$query = $this->entityManager->createQueryBuilder()
			->select('u')
			->from(Url::class, 'u');

		if($request->getId() !== null) {
			$query->andWhere('u.id = :urlId')
				->setParameter(':urlId', $request->getId());
		}

		if($request->getSourceUrl() !== null) {

			$query->where('u.sourceUrl = :sourceUrl')
				->setParameter(':sourceUrl', $request->getSourceUrl());
		}

		if($request->getMaxResults() !== 0) {
			$query->setMaxResults($request->getMaxResults());
		}

		return $query->getQuery()->getOneOrNullResult();
	}

	public function resolveUpdateUrl(UrlFilterRequest $request): ?int
	{

		$query = $this->entityManager->createQueryBuilder()
			->update(Url::class, 'u');

		if($request->getCounter() !== null) {
			$query->set('u.counter', ':counter')
				->setParameter(':counter', $request->getCounter());
		}

		if($request->getId() !== null) {
			$query->where('u.id = :urlId')
				->setParameter(':urlId', $request->getId());
		}

		return $query->getQuery()->getSingleScalarResult();
	}

}
