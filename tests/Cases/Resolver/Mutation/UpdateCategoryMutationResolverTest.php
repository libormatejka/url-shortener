<?php declare(strict_types = 1);

namespace Tests\Cases\Resolver\Mutation;

use App\Model\Resolver\Mutation\Category\IUpdateCategoryMutationResolver;
use App\Model\Type\InputObjectType\Category\UpdateCategoryRequest;
use Tests\Kit\ResolverTestCase;

final class UpdateCategoryMutationResolverTest extends ResolverTestCase
{

	public function testResolveUpdateCategory(): void
	{

		$category = $this->createTestCategory();

		$updateCategory = new UpdateCategoryRequest();
		$expectedTitle = "Upravená kategorie";
		$expectedSlug = "Upravený obsah kurzu";
		$expectedUserId = "Upravený obsah kurzu";

		$updateCategory->setTitle($expectedTitle);
		$updateCategory->setSlug($expectedSlug);

		$updateResolver = $this->getContainer()->getByType( IUpdateCategoryMutationResolver::class);
		$updateCategory = $updateResolver->resolveUpdateCategory( $category, $updateCategory );

		self::assertSame($expectedTitle, $updateCategory->getTitle());
		self::assertSame($expectedSlug, $updateCategory->getSlug());

	}

}
