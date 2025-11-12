<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Category;

use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\User;
use App\Model\Type\InputObjectType\Category\CreateCategoryRequest;
use Doctrine\ORM\EntityManagerInterface;

final class CreateCategoryMutationResolver implements ICreateCategoryMutationResolver
{

	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveCreateCategory(CreateCategoryRequest $request): Category
	{

		$category = new Category();
		$category->setTitle( $request->getTitle() );
		$category->setSlug( $request->getSlug() );
		$user = $this->entityManager->getRepository(User::class)->find($request->getUserId());
		$category->setUser( $user );

		$this->entityManager->persist($category);
		$this->entityManager->flush();
		return $category;

	}

}
