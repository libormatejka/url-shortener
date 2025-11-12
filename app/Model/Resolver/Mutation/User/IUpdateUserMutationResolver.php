<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\User;

use App\Model\Database\Entity\User;
use App\Model\Type\InputObjectType\User\UpdateUserRequest;

interface IUpdateUserMutationResolver
{

	public function resolveUpdateUser(User $url, UpdateUserRequest $request): User;

}
