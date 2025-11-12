<?php declare(strict_types = 1);

namespace Tests\Kit;

use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Url;
use App\Model\Resolver\Mutation\Category\ICreateCategoryMutationResolver;
use App\Model\Resolver\Mutation\Url\ICreateUrlMutationResolver;
use App\Model\Type\InputObjectType\Category\CreateCategoryRequest;
use App\Model\Type\InputObjectType\Url\CreateUrlRequest;
use DateTime;

abstract class ResolverTestCase extends ContainerTestCase
{

	protected function createTestUrl(): Url
	{
		// Vytvoření requestu
		$resolver = $this->getContainer()->getByType(ICreateUrlMutationResolver::class);
		$request = new CreateUrlRequest();

		// Naplnění daty a vytvoření requestu
		$expectedTitle = "Nový nadpis";
		$expectedSourceUrl = "Nový zdrojová url";
		$expectedDestinationUrl = "Nová cílová url";
		$expectedComment = "Nový komentář";
		$expectedPublishedAt = new DateTime();
		$expectedCategoryId = 1;
		$expectedUserId = 1;
		$expectedCounter = 15;

		$request->setTitle($expectedTitle);
		$request->setSourceUrl($expectedSourceUrl);
		$request->setDestinationUrl($expectedDestinationUrl);
		$request->setComment($expectedComment);
		$request->setPublishedAt($expectedPublishedAt);
		$request->setCategoryId($expectedCategoryId);
		$request->setUserId($expectedUserId);
		$request->setCounter($expectedCounter);

		// Vrací vytvoření entity s custom request daty
		return $resolver->resolveCreateUrl($request);
	}

	protected function createTestCategory(): Category
	{
		$resolver = $this->getContainer()->getByType(ICreateCategoryMutationResolver::class);
		$request = new CreateCategoryRequest();

		$expectedTitle = "Nová kategorie";
		$expectedSlug = "slug-kategorie";
		$expectedUserId = 1;

		$request->setTitle($expectedTitle);
		$request->setSlug($expectedSlug);
		$request->setUserId($expectedUserId);

		return $resolver->resolveCreateCategory($request);
	}

}
