<?php declare(strict_types = 1);

namespace Tests\Cases\Resolver\Mutation;

use App\Model\Resolver\Mutation\Url\IUpdateUrlMutationResolver;
use App\Model\Type\InputObjectType\Url\UpdateUrlRequest;
use DateTime;
use Tests\Kit\ResolverTestCase;

final class UpdateUrlMutationResolverTest extends ResolverTestCase
{

	public function testResolveUpdateUrl(): void
	{

		// Vytvoření entity Url
		$url = $this->createTestUrl();

		// Upravení entity vlastními daty a vytvoření update requestu
		$updateUrl = new UpdateUrlRequest();
		$expectedTitle = "Nový nadpis";
		$expectedSourceUrl = "source-url-".rand(0, 999);
		$expectedDestinationUrl = "https://www.example.com/";
		$expectedComment = "Nový komentář";
		$expectedPublishedAt = new DateTime();
		$expectedCampaign = "upravena-kampan-test";
		$expectedUtmMedium = "upravena-medium-test";
		$expectedUtmSource = "upravena-source-test";
		$expectedUtmTerm = "upravena-term-test";
		$expectedUtmContent = "upravena-content-test";
		$expectedCategoryId = 2;
		$expectedUserId = 1;

		$updateUrl->setTitle($expectedTitle);
		$updateUrl->setSourceUrl($expectedSourceUrl);
		$updateUrl->setDestinationUrl($expectedDestinationUrl);
		$updateUrl->setComment($expectedComment);
		$updateUrl->setPublishedAt($expectedPublishedAt);
		$updateUrl->setCategoryId($expectedCategoryId);

		// Provede update
		$updateResolver = $this->getContainer()->getByType( IUpdateUrlMutationResolver::class);
		$updateUrl = $updateResolver->resolveUpdateUrl( $url, $updateUrl );

		// Assert test na porovnání dat
		self::assertSame($expectedTitle, $updateUrl->getTitle());
		self::assertSame($expectedSourceUrl, $updateUrl->getSourceUrl());
		self::assertSame($expectedDestinationUrl, $updateUrl->getDestinationUrl());
		self::assertSame($expectedComment, $updateUrl->getComment());

		if($updateUrl->getCategory() !== null) {
			self::assertSame($expectedCategoryId, $updateUrl->getCategory()->getId());
		}

	}

}
