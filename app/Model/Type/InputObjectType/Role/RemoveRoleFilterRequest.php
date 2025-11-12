<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Role;

final class RemoveRoleFilterRequest
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
	public static function fromArray(array $data): RemoveRoleFilterRequest
	{

		$request = new RemoveRoleFilterRequest();
		$request->setId( $data['id'] );

		return $request;
	}

}
