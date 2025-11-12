<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Category;

use App\Model\Database\Entity\Category;
use App\Model\Resolver\IResolver;
use App\Model\Type\InputObjectType\Category\CategoryRequest;

interface ICategoryQueryResolver extends IResolver
{

	public function resolveCategory(CategoryRequest $request): ?Category;

}
