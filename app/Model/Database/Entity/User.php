<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class User
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", nullable=false)
	 */
	private int $id;

	/**
	 * @var Collection<int, Url>
	 * @ORM\OneToMany(targetEntity="Url", mappedBy="user")
	 */
	private Collection $urls;

	/**
	 * @var Collection<int, Category>
	 * @ORM\OneToMany(targetEntity="Category", mappedBy="user")
	 */
	private Collection $categories;

	public function __construct()
	{
		$this->urls = new ArrayCollection();
		$this->categories = new ArrayCollection();
	}

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private string $firstname;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private string $lastname;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private string $username;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private string $email;

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private string $password;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 */
	private ?DateTime $createdAt;

	/**
	 * @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
	 * @ORM\JoinColumn(nullable=true)
	 */
	private ?Role $role;

	public function getId(): int
	{
		return $this->id;
	}

	public function getFirstname(): string
	{
		return $this->firstname;
	}

	public function setFirstname(string $firstname): void
	{
		$this->firstname = $firstname;
	}

	public function getLastname(): string
	{
		return $this->lastname;
	}

	public function setLastname(string $lastname): void
	{
		$this->lastname = $lastname;
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function setUsername(string $username): void
	{
		$this->username = $username;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	public function getCreatedAt(): ?DateTime
	{
		return $this->createdAt;
	}

	public function setCreatedAt(?DateTime $createdAt): void
	{
		$this->createdAt = $createdAt;
	}

	public function getRole(): ?Role
	{
		return $this->role;
	}

	public function setRole(?Role $role): void
	{
		$this->role = $role;
	}

}
