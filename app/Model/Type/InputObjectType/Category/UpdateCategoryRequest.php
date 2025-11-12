<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Category;

final class UpdateCategoryRequest
{

	private string $title;
	private string $slug;

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function getSlug(): string
	{
		return $this->slug;
	}

	public function setSlug(string $slug): void
	{
		$this->slug = $slug;
	}

	/**
	 * @param array{title: string,slug: string} $data
	 */
	public static function fromArray(array $data): UpdateCategoryRequest
	{
		$request = new UpdateCategoryRequest();
		$request->setTitle($data['title']);
		$request->setSlug($data['slug']);

		return $request;
	}

}
