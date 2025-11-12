<?php declare(strict_types = 1);

namespace App\Module\Front\Url;

use App\Model\Resolver\Query\Url\IUrlQueryResolver;
use App\Model\Type\InputObjectType\Url\UrlFilterRequest;
use App\Module\Front\FrontPresenter;

final class UrlPresenter extends FrontPresenter
{

	private IUrlQueryResolver $urlQueryResolver;

	public function __construct(IUrlQueryResolver $urlQueryResolver)
	{
		parent::__construct();
		$this->urlQueryResolver = $urlQueryResolver;
	}

	public function actionDetail(string $slug): void
	{

		$request = new UrlFilterRequest();
		$request->setSourceUrl($slug);
		$request->setMaxResults(1);

		$url = $this->urlQueryResolver->resolveUrl($request);

		if ($url === null) {
			$this->error("Stránka nebyla nalezena.");
		}

		// URL Counter
		$requestCounterUpdate = new UrlFilterRequest();
		$requestCounterUpdate->setCounter($url->getCounter()+1);
		$requestCounterUpdate->setId($url->getId());

		$counterUpdate = $this->urlQueryResolver->resolveUpdateUrl($requestCounterUpdate);
		$this->redirectUrl($url->getDestinationUrl());

	}

}
