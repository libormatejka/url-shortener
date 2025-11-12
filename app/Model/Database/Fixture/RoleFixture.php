<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\Role;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class RoleFixture extends AbstractFixture implements OrderedFixtureInterface
{

	public function load(ObjectManager $objectManager): void
	{
		$rolesData = [

			[
				"name" => "Guest",
			],
			[
				"name" => "Moderator",
			],
			[
				"name" => "Admin",
			],

		];

		foreach( $rolesData as $roleData ) {

			$role = new Role();
			$role->setName( $roleData["name"] );

			$objectManager->persist($role);

		}

		$objectManager->flush();

	}

	public function getOrder(): int
	{
		return 1;
	}

}
