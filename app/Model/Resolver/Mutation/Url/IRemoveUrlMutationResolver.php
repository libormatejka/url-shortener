<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Url;

use App\Model\Type\InputObjectType\Url\RemoveUrlRequest;

interface IRemoveUrlMutationResolver
{

	public function resolveRemoveUrl(RemoveUrlRequest $request): void;

}
