<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Category;

final class CreateCategoryRequest
{

	private string $title;
	private string $slug;
	private int $userId;

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

	public function getUserId(): int
	{
		return $this->userId;
	}

	public function setUserId(int $userId): void
	{
		$this->userId = $userId;
	}

	/**
	 * @param array{title: string, slug: string, user: int} $data
	 */
	public static function fromArray(array $data): CreateCategoryRequest
	{
		$request = new CreateCategoryRequest();
		$request->setTitle($data['title']);
		$request->setSlug($data['slug']);
		$request->setUserId($data['user']);

		return $request;
	}

}
