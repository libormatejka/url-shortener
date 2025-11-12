<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Login;

use App\Model\Resolver\IResolver;
use App\Model\Type\InputObjectType\Login\LoginRequest;

interface ILoginMutationResolver extends IResolver
{

	public function resolveLogin(LoginRequest $request): bool;

}
