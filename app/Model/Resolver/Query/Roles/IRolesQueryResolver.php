<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Roles;

use App\Model\Database\Entity\Role;
use App\Model\Resolver\IResolver;
use App\Model\Type\InputObjectType\Roles\RolesFilterRequest;

interface IRolesQueryResolver extends IResolver
{

	/**
	 * @return array<int, Role>
	 */
	public function resolveRoles(RolesFilterRequest $request): array;

}
