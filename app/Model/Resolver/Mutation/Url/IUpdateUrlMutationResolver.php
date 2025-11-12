<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Url;

use App\Model\Database\Entity\Url;
use App\Model\Type\InputObjectType\Url\UpdateUrlRequest;

interface IUpdateUrlMutationResolver
{

	public function resolveUpdateUrl(Url $url, UpdateUrlRequest $request): Url;

}
