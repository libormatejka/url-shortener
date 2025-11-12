<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\User;

use App\Model\Type\InputObjectType\User\RemoveUserRequest;

interface IRemoveUserMutationResolver
{

	public function resolveRemoveUser(RemoveUserRequest $request): void;

}
