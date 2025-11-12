<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Category;

final class RemoveCategoryRequest
{

	private int $id;

	public function getId(): int
	{
		return $this->id;
	}

	public function setId(int $id): void
	{
		$this->id = $id;
	}

	/**
	 * @param array<int> $data
	 */
	public static function fromArray(array $data): RemoveCategoryRequest
	{

		$request = new RemoveCategoryRequest();
		$request->setId( $data['id'] );

		return $request;
	}

}
