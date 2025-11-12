<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Category;

use App\Model\Database\Entity\Category;
use App\Model\Type\InputObjectType\Category\UpdateCategoryRequest;
use Doctrine\ORM\EntityManagerInterface;

final class UpdateCategoryMutationResolver implements IUpdateCategoryMutationResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveUpdateCategory(Category $category, UpdateCategoryRequest $request): Category
	{
		$category->setTitle( $request->getTitle() );
		$category->setSlug( $request->getSlug() );
		$this->entityManager->flush();

		return $category;
	}

}
