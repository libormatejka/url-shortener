<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Url
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", nullable=false)
	 */
	private int $id;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private string $sourceUrl;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private string $destinationUrl;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private string $title;

	/**
	 * @ORM\Column(type="text", nullable=false)
	 */
	private string $comment;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private ?DateTime $publishedAt;

	/**
	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="urls")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private ?Category $category;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="urls")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private ?User $user;

	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	private ?int $counter;

	public function getId(): int
	{
		return $this->id;
	}

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

	public function getComment(): string
	{
		return $this->comment;
	}

	public function setComment(string $comment): void
	{
		$this->comment = $comment;

	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function getPublishedAt(): ?DateTime
	{
		return $this->publishedAt;
	}

	public function setPublishedAt(?DateTime $publishedAt): void
	{
		$this->publishedAt = $publishedAt;
	}

	public function getCategory(): ?Category
	{
		return $this->category;
	}

	public function setCategory(?Category $category): void
	{
		$this->category = $category;
	}

	public function getUser(): ?User
	{
		return $this->user;
	}

	public function setUser(?User $user): void
	{
		$this->user = $user;
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
