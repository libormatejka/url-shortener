<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\User;

use App\Model\Database\Entity\User;
use App\Model\Type\InputObjectType\User\RemoveUserRequest;
use Nettrine\ORM\EntityManagerDecorator;

final class RemoveUserMutationResolver implements IRemoveUserMutationResolver
{

	private EntityManagerDecorator $entityManager;

	public function __construct(EntityManagerDecorator $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveRemoveUser(RemoveUserRequest $request): void
	{

		$User = $this->entityManager->getRepository(User::class)->find($request->getId());
		if($User !== null)
		{
			$this->entityManager->remove($User);
			$this->entityManager->flush();
		}

	}

}
