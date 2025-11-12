<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Category
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", nullable=false)
	 */
	private int $id;

	/**
	 * @var Collection<int, Url>
	 * @ORM\OneToMany(targetEntity="Url", mappedBy="category")
	 */
	private Collection $urls;

	public function __construct()
	{
		$this->urls = new ArrayCollection();
	}

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private string $title;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private string $slug;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="categories")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private ?User $user;

	public function getId(): int
	{
		return $this->id;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function getSlug(): string
	{
		return $this->slug;
	}

	public function setSlug(string $slug): void
	{
		$this->slug = $slug;
	}

	public function getUser(): ?User
	{
		return $this->user;
	}

	public function setUser(?User $user): void
	{
		$this->user = $user;
	}

}
