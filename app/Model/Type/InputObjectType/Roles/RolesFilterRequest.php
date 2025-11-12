<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Roles;

final class RolesFilterRequest
{

	private ?int $id = null;
	private ?string $name = null;
	private ?int $limit = null;
	private ?int $offset = null;

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

	public function getLimit(): ?int
	{
		return $this->limit;
	}

	public function setLimit(?int $limit): void
	{
		$this->limit = $limit;
	}

	public function getOffset(): ?int
	{
		return $this->offset;
	}

	public function setOffset(?int $offset): void
	{
		$this->offset = $offset;
	}

}
