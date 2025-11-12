<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Role;

final class UpdateRoleRequest
{

	private string $name;

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @param array{name: string} $data
	 */
	public static function fromArray(array $data): UpdateRoleRequest
	{
		$request = new UpdateRoleRequest();
		$request->setName($data['name']);

		return $request;
	}

}
