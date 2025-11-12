<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Role;

use App\Model\Type\InputObjectType\Role\RemoveRoleFilterRequest;

interface IRemoveRoleMutationResolver
{

	public function resolveRemoveRole(RemoveRoleFilterRequest $request): void;

}
