<?php declare(strict_types = 1);

namespace App\Module\Api\Url;

use App\Model\Resolver\Query\Urls\IUrlsQueryResolver;
use App\Model\Type\InputObjectType\Urls\UrlsFilterRequest;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Presenter;

final class UrlPresenter extends Presenter
{

	private IUrlsQueryResolver $urlsQueryResolver;

	public function __construct(
		IUrlsQueryResolver $urlsQueryResolver,
	)
	{
		parent::__construct();
		$this->urlsQueryResolver = $urlsQueryResolver;
	}

	public function actionPosts(): void
	{
		$this->sendResponse( new JsonResponse([]) );
	}

	public function actionPost(): void
	{
		$this->sendResponse( new JsonResponse([]) );
	}

	public function actionUrls(): void
	{
		$request = new UrlsFilterRequest();
		$urls = $this->urlsQueryResolver->resolveUrls($request);

		$data = [];
		foreach($urls as $url){

			$data[] = [
				"id" => $url->getId(),
				"title" => $url->getTitle(),
				"sourceUrl" => $url->getSourceUrl(),
				"destinationUrl" => $url->getDestinationUrl(),
				"comment" => $url->getComment(),
				"publishedAt" => $url->getPublishedAt(),
			];

		}

		$this->sendJson( $data );

	}

}
