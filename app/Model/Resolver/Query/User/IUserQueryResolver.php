<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\User;

use App\Model\Database\Entity\User;
use App\Model\Resolver\IResolver;
use App\Model\Type\InputObjectType\User\UserFilterRequest;

interface IUserQueryResolver extends IResolver
{

	public function resolveUser(UserFilterRequest $request): ?User;

}
