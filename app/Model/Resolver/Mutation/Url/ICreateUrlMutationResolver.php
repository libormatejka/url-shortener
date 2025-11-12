<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Url;

use App\Model\Database\Entity\Url;
use App\Model\Type\InputObjectType\Url\CreateUrlRequest;

interface ICreateUrlMutationResolver
{

	public function resolveCreateUrl(CreateUrlRequest $request): Url;

}
