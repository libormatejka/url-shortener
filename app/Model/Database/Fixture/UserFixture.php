<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\Role;
use App\Model\Database\Entity\User;
use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nette\Security\Passwords;

final class UserFixture extends AbstractFixture implements OrderedFixtureInterface
{

	public function load(ObjectManager $objectManager): void
	{
		$usersData = [

			[
				"firstname" => "Libor",
				"lastname" => "Matějka",
				"username" => "libormatejka",
				"email" => "libor.matejka@hotmail.cz",
				"password" => "12345",
				"createdAt" => new DateTime("2001-10-01 10:00"),
				"role" => 3,
			],
			[
				"firstname" => "Test",
				"lastname" => "Testovič",
				"username" => "testovic",
				"email" => "test@example.com",
				"password" => "test@example.com",
				"createdAt" => new DateTime("2021-10-01 10:00"),
				"role" => 1,
			],
			[
				"firstname" => "Guest",
				"lastname" => "Guestovič",
				"username" => "guest-guestovic",
				"email" => "guest@example.com",
				"password" => "guest@example.com",
				"createdAt" => new DateTime("2019-10-01 10:00"),
				"role" => 1,
			],
			[
				"firstname" => "Moderator",
				"lastname" => "Moderatorovič",
				"username" => "moderator-moderatorovic",
				"email" => "moderator@example.com",
				"password" => "moderator@example.com",
				"createdAt" => new DateTime("2017-10-01 10:00"),
				"role" => 2,
			],

		];

		foreach( $usersData as $userData ) {

			$roleRepository = $objectManager->getRepository(Role::class);
			$role = $roleRepository->find( $userData["role"] );

			$passwords = new Passwords();
			$user = new User();
			$user->setFirstname( $userData["firstname"] );
			$user->setLastname( $userData["lastname"] );
			$user->setusername( $userData["username"] );
			$user->setEmail( $userData["email"] );
			$user->setPassword( $passwords->hash($userData["password"]) );
			$user->setCreatedAt( $userData["createdAt"] );
			$user->setRole( $role );

			$objectManager->persist($user);

		}

		$objectManager->flush();

	}

	public function getOrder(): int
	{
		return 2;
	}

}
