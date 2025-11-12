<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Category;

use App\Model\Type\InputObjectType\Category\RemoveCategoryRequest;

interface IRemoveCategoryMutationResolver
{

	public function resolveRemoveCategory(RemoveCategoryRequest $request): void;

}
