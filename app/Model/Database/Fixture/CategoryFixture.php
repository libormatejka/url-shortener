<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class CategoryFixture extends AbstractFixture implements OrderedFixtureInterface
{

	public function load(ObjectManager $objectManager): void
	{
		$categoriesData = [

			[
				"title" => "Hry",
				"slug" => "hry",
			],
			[
				"title" => "Filmy",
				"slug" => "filmy",
			],
			[
				"title" => "Knihy",
				"slug" => "knihy",
			],

		];

		foreach( $categoriesData as $categoryData ) {

			$userRepository = $objectManager->getRepository(User::class);
			$user = $userRepository->find(rand(1, 2));

			$category = new Category();
			$category->setTitle( $categoryData["title"] );
			$category->setSlug( $categoryData["slug"] );
			$category->setUser($user);

			$objectManager->persist($category);

		}

		$objectManager->flush();

	}

	public function getOrder(): int
	{
		return 3;
	}

}
