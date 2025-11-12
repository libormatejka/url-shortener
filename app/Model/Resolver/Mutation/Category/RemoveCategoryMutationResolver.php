<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Category;

use App\Model\Database\Entity\Category;
use App\Model\Type\InputObjectType\Category\RemoveCategoryRequest;
use Nettrine\ORM\EntityManagerDecorator;

final class RemoveCategoryMutationResolver implements IRemoveCategoryMutationResolver
{

	private EntityManagerDecorator $entityManager;

	public function __construct(EntityManagerDecorator $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveRemoveCategory(RemoveCategoryRequest $request): void
	{

		$category = $this->entityManager->getRepository(Category::class)->find($request->getId());
		if($category !== null)
		{
			$this->entityManager->remove($category);
			$this->entityManager->flush();
		}

	}

}
