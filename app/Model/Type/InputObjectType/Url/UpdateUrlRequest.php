<?php declare(strict_types = 1);

namespace App\Model\Type\InputObjectType\Url;

use DateTime;

final class UpdateUrlRequest
{

	private string $sourceUrl;
	private string $destinationUrl;
	private string $title;
	private string $comment;
	public DateTime $publishedAt;
	public string $utmCampaign;
	public string $utmMedium;
	public string $utmSource;
	public string $utmTerm;
	public string $utmContent;
	public int $categoryId;
	public int $counter;

	public function getSourceUrl(): string
	{
		return $this->sourceUrl;
	}

	public function setSourceUrl(string $sourceUrl): void
	{
		$this->sourceUrl = $sourceUrl;
	}

	public function getDestinationUrl(): string
	{
		return $this->destinationUrl;
	}

	public function setDestinationUrl(string $destinationUrl): void
	{
		$this->destinationUrl = $destinationUrl;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function getComment(): string
	{
		return $this->comment;
	}

	public function setComment(string $comment): void
	{
		$this->comment = $comment;
	}

	public function getPublishedAt(): ?DateTime
	{
		return $this->publishedAt;
	}

	public function setPublishedAt(?DateTime $publishedAt): void
	{
		$this->publishedAt = $publishedAt;
	}

	public function getCategoryId(): int
	{
		return $this->categoryId;
	}

	public function setCategoryId(int $categoryId): void
	{
		$this->categoryId = $categoryId;
	}

	public function getCounter(): ?int
	{
		return $this->counter;
	}

	public function setCounter(?int $counter): void
	{
		$this->counter = $counter;
	}


	/**
	 * @param array{
	 * sourceUrl: string,
	 * destinationUrl: string,
	 * title: string,
	 * comment: string,
	 * categoryId: int,
	 * } $data
	 */

	public static function fromArray(array $data): UpdateUrlRequest
	{
		$request = new UpdateUrlRequest();
		$request->setSourceUrl($data['sourceUrl']);
		$request->setDestinationUrl($data['destinationUrl']);
		$request->setTitle($data['title']);
		$request->setComment($data['comment']);
		$request->setCategoryId($data["categoryId"]);

		return $request;
	}

}
