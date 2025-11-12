<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Categories;

use App\Model\Database\Entity\Category;
use App\Model\Resolver\IResolver;
use App\Model\Type\InputObjectType\Category\CategoryRequest;

interface ICategoriesQueryResolver extends IResolver
{

	/**
	 * @return array<int, Category>
	 */
	public function resolveCategories(CategoryRequest $request): array;

}
