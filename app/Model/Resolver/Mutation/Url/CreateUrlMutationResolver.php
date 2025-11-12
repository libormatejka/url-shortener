<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Url;

use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Url;
use App\Model\Database\Entity\User;
use App\Model\Type\InputObjectType\Url\CreateUrlRequest;
use Nettrine\ORM\EntityManagerDecorator;

final class CreateUrlMutationResolver implements ICreateUrlMutationResolver
{

	private EntityManagerDecorator $entityManager;

	public function __construct(EntityManagerDecorator $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveCreateUrl(CreateUrlRequest $request): Url
	{

		$url = new Url();
		$url->setSourceUrl( $request->getSourceUrl() );
		$url->setDestinationUrl( $request->getDestinationUrl() );
		$url->setTitle( $request->getTitle() );
		$url->setComment( $request->getComment() );
		$url->setPublishedAt( $request->getPublishedAt() );
		$url->setCounter( $request->getCounter() );
		$category = $this->entityManager->getRepository(Category::class)->find($request->getCategoryId());
		$url->setCategory( $category );

		$user = $this->entityManager->getRepository(User::class)->find($request->getUserId());
		$url->setUser( $user );

		$this->entityManager->persist($url);
		$this->entityManager->flush();
		return $url;

	}

}
