<?php declare(strict_types = 1);

namespace Tests\Cases\Resolver\Mutation;

use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Url;
use App\Model\Resolver\Mutation\Url\ICreateUrlMutationResolver;
use App\Model\Type\InputObjectType\Url\CreateUrlRequest;
use DateTime;
use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Tests\Kit\ResolverTestCase;

final class CreateUrlMutationResolverTest extends ResolverTestCase
{

	public function testResolveCreateUrl(): void
	{
		$entityManager = $this->getContainer()->getByType(EntityManagerDecorator::class);
		$resolver = $this->getContainer()->getByType( ICreateUrlMutationResolver::class);
		$request = new CreateUrlRequest();

		// Naplnění daty a vytvoření requestu
		$expectedTitle = "Nový nadpis";
		$expectedSourceUrl = "source-url-".rand(0, 999);
		$expectedDestinationUrl = "https://www.example.com/";
		$expectedComment = "Nový komentář";
		$expectedPublishedAt = new DateTime();
		$expectedCategoryId = 13;
		$expectedUserId = 1;
		$expectedCounter = 2;
		$expectedCategory = $entityManager->getRepository(Category::class)->find($expectedCategoryId);

		$request->setTitle($expectedTitle);
		$request->setSourceUrl($expectedSourceUrl);
		$request->setDestinationUrl($expectedDestinationUrl);
		$request->setComment($expectedComment);
		$request->setPublishedAt($expectedPublishedAt);
		$request->setCategoryId($expectedCategoryId);
		$request->setUserId($expectedUserId);
		$request->setCounter($expectedCounter);

		$id = $resolver->resolveCreateUrl($request)->getId();
		$entity = $entityManager->getRepository(Url::class)->find($id);

		self::assertNotNull($entity);
		self::assertSame($expectedTitle, $entity->getTitle());
		self::assertSame($expectedSourceUrl, $entity->getSourceUrl());
		self::assertSame($expectedDestinationUrl, $entity->getDestinationUrl());
		self::assertSame($expectedComment, $entity->getComment());
		self::assertSame($expectedCategory, $entity->getCategory());

	}

}
