<?php declare(strict_types = 1);

namespace App\Model\Database\Fixture;

use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Url;
use App\Model\Database\Entity\User;
use DateTime;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class UrlFixture extends AbstractFixture implements OrderedFixtureInterface
{

	public function load(ObjectManager $objectManager): void
	{
		$urls = [

			"0" => [
				"sourceUrl" => "source-url-1",
				"destinationUrl" => "https://www.collectorboy.cz/destination-url/",
				"title" => "Název #1",
				"comment" => "In sem justo, commodo ut, suscipit at, pharetra vitae, orci. Aliquam id dolor.
				Sed vel lectus. Donec odio tempus molestie, porttitor ut, iaculis quis, sem. ",
				"publishedAt" => new DateTime("2001-10-01"),
				"counter" => 23,
			],

			"1" => [
				"sourceUrl" => "source-url-2",
				"destinationUrl" => "https://www.collectorboy.cz/destination-url/",
				"title" => "Název #2",
				"comment" => "In dapibus augue non sapien. Aenean fermentum risus id tortor. Morbi scelerisque
				luctus velit. Etiam egestas wisi a erat. Class aptent taciti sociosqu ad litora torquent per
				conubia nostra, per inceptos hymenaeos. Itaque earum rerum hic tenetur a sapiente delectus, ut
				aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores
				repellat. Sed convallis magna eu sem. Integer malesuada.",
				"publishedAt" => new DateTime("2011-10-01"),
				"counter" => 2311,
			],

			"2" => [
				"sourceUrl" => "source-url-3",
				"destinationUrl" => "https://www.collectorboy.cz/destination-url/",
				"title" => "Název #3",
				"comment" => "In enim a arcu imperdiet malesuada. Donec quis nibh at felis congue commodo.
				Etiam posuere lacus quis dolor. Pellentesque pretium lectus id turpis. Fusce tellus. Et
				harum quidem rerum facilis est et expedita distinctio. Nullam at arcu a est sollicitudin
				euismod. Donec iaculis gravida nulla.",
				"publishedAt" => new DateTime("2000-10-01"),
				"counter" => 0,
			],

		];

		foreach( $urls as $item ) {

			$categoryRepository = $objectManager->getRepository(Category::class);
			$category = $categoryRepository->find(rand(1, 3));

			$userRepository = $objectManager->getRepository(User::class);
			$user = $userRepository->find(rand(1, 2));

			$url = new Url();
			$url->setSourceUrl( $item["sourceUrl"] );
			$url->setDestinationUrl( $item["destinationUrl"] );
			$url->setTitle( $item["title"] );
			$url->setComment( $item["comment"] );
			$url->setPublishedAt( new DateTime() );
			$url->setCategory($category);
			$url->setUser($user);
			$url->setCounter( $item["counter"] );

			$objectManager->persist($url);

		}

		$objectManager->flush();

	}

	public function getOrder(): int
	{
		return 4;
	}

}
