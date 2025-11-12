<?php declare(strict_types = 1);

namespace App\Module\Admin\Category\Component\CategoryForm;

use Nette\Application\UI\Control;

final class CategoryFormValues extends Control
{

	public string $title;
	public string $slug;

	/**
	 * @return array{title: string, slug: string}
	 */
	public function toArray(): array
	{
		return ["title" => $this->title, "slug" => $this->slug];
	}

}
