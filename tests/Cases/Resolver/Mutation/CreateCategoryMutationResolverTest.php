<?php declare(strict_types = 1);

namespace Tests\Cases\Resolver\Mutation;

use App\Model\Database\Entity\Category;
use App\Model\Resolver\Mutation\Category\ICreateCategoryMutationResolver;
use App\Model\Type\InputObjectType\Category\CreateCategoryRequest;
use Doctrine\ORM\EntityManagerInterface;
use Tests\Kit\ResolverTestCase;

final class CreateCategoryMutationResolverTest extends ResolverTestCase
{

	public function testResolveCreateCategory(): void
	{
		$entityManager = $this->getContainer()->getByType(EntityManagerInterface::class);
		$resolver = $this->getContainer()->getByType( ICreateCategoryMutationResolver::class);
		$request = new CreateCategoryRequest();

		$expectedTitle = "Nová testovací kategorie";
		$expectedSlug = "nova-testovaci-kategorie";
		$expectedUserId = 1;

		$request->setTitle($expectedTitle);
		$request->setSlug($expectedSlug);
		$request->setUserId($expectedUserId);

		$id = $resolver->resolveCreateCategory($request)->getId();
		$entity = $entityManager->getRepository(Category::class)->find($id);

		self::assertNotNull($entity);
		self::assertSame($expectedTitle, $entity->getTitle());
		self::assertSame($expectedSlug, $entity->getSlug());
	}

}
