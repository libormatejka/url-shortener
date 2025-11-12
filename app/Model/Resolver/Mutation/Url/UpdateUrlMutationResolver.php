<?php declare(strict_types = 1);

namespace App\Model\Resolver\Mutation\Url;

use App\Model\Database\Entity\Category;
use App\Model\Database\Entity\Url;
use App\Model\Type\InputObjectType\Url\UpdateUrlRequest;
use Nettrine\ORM\EntityManagerDecorator;

final class UpdateUrlMutationResolver implements IUpdateUrlMutationResolver
{

	private EntityManagerDecorator $entityManager;

	public function __construct(EntityManagerDecorator $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function resolveUpdateUrl(Url $url, UpdateUrlRequest $request): Url
	{
		$url->setSourceUrl( $request->getSourceUrl() );
		$url->setDestinationUrl( $request->getDestinationUrl() );
		$url->setTitle( $request->getTitle() );
		$url->setComment( $request->getComment() );
		$category = $this->entityManager->getRepository(Category::class)->find($request->getCategoryId());
		$url->setCategory($category);

		$this->entityManager->flush();

		return $url;
	}

}
