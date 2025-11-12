<?php declare(strict_types = 1);

namespace Tests\Cases\Resolver\Mutation;

use App\Model\Database\Entity\Category;
use App\Model\Resolver\Mutation\Category\IRemoveCategoryMutationResolver;
use App\Model\Type\InputObjectType\Category\RemoveCategoryRequest;
use Doctrine\ORM\EntityManagerInterface;
use Tests\Kit\ResolverTestCase;

final class RemoveCategoryMutationResolverTest extends ResolverTestCase
{

	public function testResolveDeleteCategory(): void
	{
		$category = $this->createTestCategory();
		$categoryId = $category->getId();
		$categoryUserId = 1;

		$array = ["id" => $categoryId, "userId" => $categoryUserId];
		$request = RemoveCategoryRequest::fromArray($array);

		$entityInterface = $this->getContainer()->getByType(EntityManagerInterface::class);
		$remove = $this->getContainer()->getByType(IRemoveCategoryMutationResolver::class);

		$remove->resolveRemoveCategory($request);
		$removedCategory = $entityInterface->getRepository(Category::class)->find($categoryId);

		self::assertNull($removedCategory);

	}

}
