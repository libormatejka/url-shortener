<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Urls;

final class UrlsFilterRequest
{

	private ?int $id = null;
	private ?string $sourceUrl = null;
	private ?int $categoryId = null;
	private ?int $userId = null;
	private ?int $limit = null;
	private ?int $offset = null;
	public ?int $counter = null;

	public function getNotId(): ?int
	{
		return $this->id;
	}

	public function setNotId(?int $id): void
	{
		$this->id = $id;
	}

	public function getSourceUrl(): ?string
	{
		return $this->sourceUrl;
	}

	public function setSourceUrl(?string $sourceUrl): void
	{
		$this->sourceUrl = $sourceUrl;
	}

	public function getCategoryId(): ?int
	{
		return $this->categoryId;
	}

	public function setCategoryId(?int $categoryId): void
	{
		$this->categoryId = $categoryId;
	}

	public function getUserId(): ?int
	{
		return $this->userId;
	}

	public function setUserId(?int $userId): void
	{
		$this->userId = $userId;
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

	public function getCounter(): int
	{
		return $this->counter;
	}

	public function setCounter(int $counter): void
	{
		$this->counter = $counter;
	}

}
