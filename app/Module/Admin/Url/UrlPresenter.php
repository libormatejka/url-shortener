<?php declare(strict_types = 1);

namespace App\Module\Admin\Url;

use App\Model\Database\Entity\Url;
use App\Model\Resolver\Mutation\Url\IRemoveUrlMutationResolver;
use App\Model\Resolver\Query\Url\IUrlQueryResolver;
use App\Model\Resolver\Query\Urls\IUrlsQueryResolver;
use App\Model\Type\InputObjectType\Url\RemoveUrlRequest;
use App\Model\Type\InputObjectType\Url\UrlFilterRequest;
use App\Model\Type\InputObjectType\Urls\UrlsFilterRequest;
use App\Model\UI\FlashMessage;
use App\Module\Admin\AdminPresenter;
use App\Module\Admin\Url\Component\CreateUrl\CreateUrl;
use App\Module\Admin\Url\Component\CreateUrl\ICreateUrlFactory;
use App\Module\Admin\Url\Component\UpdateUrl\IUpdateUrlFactory;
use App\Module\Admin\Url\Component\UpdateUrl\UpdateUrl;
use Nette\InvalidStateException;
use Nette\Utils\Paginator;

final class UrlPresenter extends AdminPresenter
{

	private ?Url $url = null;
	private ICreateUrlFactory $createUrlFactory;
	private IUpdateUrlFactory $updateUrlFactory;
	private IRemoveUrlMutationResolver $removeUrlFactory;
	private IUrlQueryResolver $urlQueryResolver;
	private IUrlsQueryResolver $urlsQueryResolver;

	public function __construct(
		ICreateUrlFactory $createUrlFactory,
		IUpdateUrlFactory $updateUrlFactory,
		IRemoveUrlMutationResolver $removeUrlFactory,
		IUrlQueryResolver $urlQueryResolver,
		IUrlsQueryResolver $urlsQueryResolver,
	)
	{
		parent::__construct();
		$this->createUrlFactory = $createUrlFactory;
		$this->updateUrlFactory = $updateUrlFactory;
		$this->removeUrlFactory = $removeUrlFactory;
		$this->urlQueryResolver = $urlQueryResolver;
		$this->urlsQueryResolver = $urlsQueryResolver;
	}

	public function actionDefault(int $page = 1): void
	{
		// rootURL
		$httpRequest = $this->getHttpRequest();
		$url = $httpRequest->getUrl();
		$this->getTemplate()->rootUrl = $url->getHostUrl();

		// Identity
		$userId = $this->getUser()->getIdentity()->getId();

		// Paginator
		$requestUrlCount = new UrlsFilterRequest();
		$requestUrlCount->setUserId($userId);
		$urlCount = $this->urlsQueryResolver->resolveUrls($requestUrlCount);
		$this->getTemplate()->urlCount = $urlCount;

		$paginator = new Paginator();
		$paginator->setItemCount((int) count($urlCount));
		$paginator->setItemsPerPage(10);
		$paginator->setPage($page);
		$this->getTemplate()->paginator = $paginator;

		// URLs
		$requestUrl = new UrlsFilterRequest();
		$requestUrl->setLimit($paginator->getLength());
		$requestUrl->setOffset($paginator->getOffset());
		$requestUrl->setUserId($userId);
		$this->getTemplate()->urls = $this->urlsQueryResolver->resolveUrls($requestUrl);
	}

	public function actionUpdate(int $id): void
	{
		// Identity
		$userId = $this->getUser()->getIdentity()->getId();

		// Check if url author is logged user
		$isUrlAuthorRequest = new UrlFilterRequest();
		$isUrlAuthorRequest->setId($id);
		$isUrlAuthor = $this->urlQueryResolver->resolveUrl($isUrlAuthorRequest);

		if( $isUrlAuthor->getUser()->getId() !== $userId){

			$this->flashMessage("Nemáte práva upravovat tuto url.", FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		}

		$this->loadUrl();
	}

	public function actionDetail(int $id): void
	{
		// Identity
		$userId = $this->getUser()->getIdentity()->getId();

		// rootURL
		$httpRequest = $this->getHttpRequest();
		$url = $httpRequest->getUrl();
		$this->getTemplate()->rootUrl = $url->getHostUrl();

		$request = new UrlFilterRequest();
		$request->setUserId($userId);
		$request->setId((int)($this->getParameter('id')));

		$url = $this->urlQueryResolver->resolveUrl($request);

		if ($url === null) {
			$this->error("URL nebyla nalezena, nebo nemáte patřičná práva pro zobrazení.");
		}

		$this->getTemplate()->url = $url;

	}

	protected function createComponentCreateUrl(): CreateUrl
	{
		$component = $this->createUrlFactory->create();
		$component->onCreate[] = function (): void {
			$this->flashMessage('Url byla vytvořena', FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		};
		return $component;

	}

	protected function createComponentUpdateUrl(): UpdateUrl
	{
		$component = $this->updateUrlFactory->create($this->getUrl());
		$component->onUpdate[] = function (): void {
			$this->flashMessage('URL byla upravena', FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		};
		return $component;
	}

	private function loadUrl(): Url
	{
		$request = new UrlFilterRequest();
		$request->setId((int)($this->getParameter('id')));
		$url = $this->urlQueryResolver->resolveUrl($request);
		if ($url === null) {
			$this->flashMessage('URL nenalezena');
			$this->redirect('default');
		}
		return $this->url = $url;
	}

	private function getUrl(): Url
	{
		if ($this->url === null) {
			throw new InvalidStateException();
		}
		return $this->url;
	}

	public function handleRemoveUrl(int $id): void
	{
		// Identity
		$userId = $this->getUser()->getIdentity()->getId();

		// Check if url author is logged user
		$isUrlAuthorRequest = new UrlFilterRequest();
		$isUrlAuthorRequest->setId($id);
		$isUrlAuthor = $this->urlQueryResolver->resolveUrl($isUrlAuthorRequest);

		if( $isUrlAuthor->getUser()->getId() !== $userId){

			$this->flashMessage("Nemáte práva smazat kategorii.", FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		}

		$request = RemoveUrlRequest::fromArray(["id" => $id]);

		$this->removeUrlFactory->resolveRemoveUrl( $request );
		$this->flashMessage("URL s ID: " . $id . " byla smazána.", FlashMessage::TYPE_SUCCESS );
		$this->redirect('default');
	}

}
