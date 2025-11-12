<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Url;

final class UrlFilterRequest
{

	private ?string $sourceUrl = null;
	private ?int $id = null;
	private int $userId;
	private int $maxResults = 0;
	private ?int $counter = 0;

	public function getSourceUrl(): ?string
	{
		return $this->sourceUrl;
	}

	public function setSourceUrl(?string $sourceUrl): void
	{
		$this->sourceUrl = $sourceUrl;
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function setId(?int $id): void
	{
		$this->id = $id;
	}

	public function getUserId(): int
	{
		return $this->userId;
	}

	public function setUserId(int $userId): void
	{
		$this->userId = $userId;
	}

	public function getMaxResults(): int
	{
		return $this->maxResults;
	}

	public function setMaxResults(int $maxResults): void
	{
		$this->maxResults = $maxResults;
	}

	public function getCounter(): ?int
	{
		return $this->counter;
	}

	public function setCounter(?int $counter): void
	{
		$this->counter = $counter;
	}

}
