<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Url;

use App\Model\Database\Entity\Url;
use App\Model\Type\InputObjectType\Url\RemoveUrlRequest;
use Nettrine\ORM\EntityManagerDecorator;

final class RemoveUrlMutationResolver implements IRemoveUrlMutationResolver
{

	private EntityManagerDecorator $entityManager;

	public function __construct(EntityManagerDecorator $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveRemoveUrl(RemoveUrlRequest $request): void
	{

		$Url = $this->entityManager->getRepository(Url::class)->find($request->getId());
		if($Url !== null)
		{
			$this->entityManager->remove($Url);
			$this->entityManager->flush();
		}

	}

}
