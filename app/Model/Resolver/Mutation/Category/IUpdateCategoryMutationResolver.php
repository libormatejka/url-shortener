<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Category;

use App\Model\Database\Entity\Category;
use App\Model\Type\InputObjectType\Category\UpdateCategoryRequest;

interface IUpdateCategoryMutationResolver
{

	public function resolveUpdateCategory(Category $category, UpdateCategoryRequest $request): Category;

}
