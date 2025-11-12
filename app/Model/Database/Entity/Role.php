<?php declare(strict_types = 1);

namespace App\Model\Database\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Role
{

	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer", nullable=false)
	 */
	private int $id;

	/**
	 * @var Collection<int, User>
	 * @ORM\OneToMany(targetEntity="User", mappedBy="role")
	 */
	private Collection $users;

	public function __construct()
	{
		$this->users = new ArrayCollection();
	}

	/**
	 * @ORM\Column(type="string", nullable=false)
	 */
	private string $name;

	public function getId(): int
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

}
