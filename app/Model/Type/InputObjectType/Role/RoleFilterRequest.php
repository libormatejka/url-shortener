<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Role;

final class RoleFilterRequest
{

	private ?int $id = null;
	private ?string $name = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): void
	{
		$this->id = $id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(?string $name): void
	{
		$this->name = $name;
	}

}
