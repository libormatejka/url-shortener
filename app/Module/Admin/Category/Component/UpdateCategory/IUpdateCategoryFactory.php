<?php declare(strict_types = 1);

namespace App\Module\Admin\Category\Component\UpdateCategory;

use App\Model\Database\Entity\Category;

interface IUpdateCategoryFactory
{

	public function create(Category $category): UpdateCategory;

}
