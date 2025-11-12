<?php declare(strict_types = 1);

namespace App\Module\Admin\Category\Component\CreateCategory;

interface ICreateCategoryFactory
{

	public function create(): CreateCategory;

}
