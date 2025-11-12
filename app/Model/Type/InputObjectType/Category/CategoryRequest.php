<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Category;

final class CategoryRequest
{

	private ?int $id = null;
	private ?int $limit = null;
	private ?int $offset = null;
	private ?int $userId = null;
	private ?string $slug = null;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): void
	{
		$this->id = $id;
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

	public function getUserId(): ?int
	{
		return $this->userId;
	}

	public function setUserId(?int $userId): void
	{
		$this->userId = $userId;
	}

	public function getSlug(): ?string
	{
		return $this->slug;
	}

	public function setSlug(?string $slug): void
	{
		$this->slug = $slug;
	}

}
