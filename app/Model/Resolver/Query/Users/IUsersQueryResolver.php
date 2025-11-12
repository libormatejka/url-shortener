<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Users;

use App\Model\Database\Entity\User;
use App\Model\Resolver\IResolver;
use App\Model\Type\InputObjectType\Users\UsersFilterRequest;

interface IUsersQueryResolver extends IResolver
{

	/**
	 * @return array<int, User>
	 */
	public function resolveUsers(UsersFilterRequest $request): array;

}
