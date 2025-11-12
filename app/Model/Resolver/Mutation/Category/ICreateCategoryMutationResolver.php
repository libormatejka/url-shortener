<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Category;

use App\Model\Database\Entity\Category;
use App\Model\Type\InputObjectType\Category\CreateCategoryRequest;

interface ICreateCategoryMutationResolver
{

	public function resolveCreateCategory(CreateCategoryRequest $request): Category;

}
