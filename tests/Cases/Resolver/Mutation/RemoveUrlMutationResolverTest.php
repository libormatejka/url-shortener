<?php declare(strict_types = 1);

namespace Tests\Cases\Resolver\Mutation;

use App\Model\Database\Entity\Url;
use App\Model\Resolver\Mutation\Url\IRemoveUrlMutationResolver;
use App\Model\Type\InputObjectType\Url\RemoveUrlRequest;
use Doctrine\ORM\EntityManagerInterface;
use Tests\Kit\ResolverTestCase;

final class RemoveUrlMutationResolverTest extends ResolverTestCase
{

	public function testResolveDeleteUrl(): void
	{
		// Vytvoření entity Url
		$Url = $this->createTestUrl();

		// Zjištění ID vytvořené entity Url
		$UrlId = $Url->getId();
		$urlUserId = 1;

		// Provede delete request
		$array = ["id" => $UrlId, "userId" => $urlUserId];
		$request = RemoveUrlRequest::fromArray($array);

		// Posle request do resolveru a smaze entitu
		$entityInterface = $this->getContainer()->getByType(EntityManagerInterface::class);
		$remove = $this->getContainer()->getByType(IRemoveUrlMutationResolver::class);

		$remove->resolveRemoveUrl($request);
		$removedUrl = $entityInterface->getRepository(Url::class)->find($UrlId);

		// Assert test na zjisteni, jestli entita je nulová, tedy neexistuje
		self::assertNull($removedUrl);

	}

}
