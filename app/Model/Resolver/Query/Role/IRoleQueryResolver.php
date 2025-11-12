<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Role;

use App\Model\Database\Entity\Role;
use App\Model\Resolver\IResolver;
use App\Model\Type\InputObjectType\Role\RoleFilterRequest;

interface IRoleQueryResolver extends IResolver
{

	public function resolveRole(RoleFilterRequest $request): ?Role;

}
