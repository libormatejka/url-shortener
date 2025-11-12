<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Role;

use App\Model\Database\Entity\Role;
use App\Model\Type\InputObjectType\Role\CreateRoleRequest;

interface ICreateRoleMutationResolver
{

	public function resolveCreateRole(CreateRoleRequest $request): Role;

}
