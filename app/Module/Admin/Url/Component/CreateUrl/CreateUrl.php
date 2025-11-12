<?php declare(strict_types = 1);

namespace App\Module\Admin\Url\Component\CreateUrl;

use App\Model\Resolver\Mutation\Url\ICreateUrlMutationResolver;
use App\Model\Resolver\Query\Categories\ICategoriesQueryResolver;
use App\Model\Resolver\Query\Urls\IUrlsQueryResolver;
use App\Model\Type\InputObjectType\Url\CreateUrlRequest;
use App\Model\Type\InputObjectType\Urls\UrlsFilterRequest;
use App\Module\Admin\Url\Component\UrlForm\UrlForm;
use App\Module\Admin\Url\Component\UrlForm\UrlFormValues;
use Nette\Application\UI\Control;
use Nette\Http\Request;
use Nette\Security\User;

final class CreateUrl extends Control
{

	/** @var array<int, callable> */
	public array $onCreate = [];
	private ICreateUrlMutationResolver $createUrlMutationResolver;
	private ICategoriesQueryResolver $categoriesQueryResolver;
	private Request $httpRequest;
	private User $user;
	private IUrlsQueryResolver $urlsQueryResolver;

	public function __construct(
		ICreateUrlMutationResolver $createUrlMutationResolver,
		ICategoriesQueryResolver $categoriesQueryResolver,
		Request $httpRequest,
		User $user,
		IUrlsQueryResolver $urlsQueryResolver,
		)
	{
		$this->categoriesQueryResolver = $categoriesQueryResolver;
		$this->createUrlMutationResolver = $createUrlMutationResolver;
		$this->httpRequest = $httpRequest;
		$this->user = $user;
		$this->urlsQueryResolver = $urlsQueryResolver;
	}

	protected function createComponentForm(): UrlForm
	{
		$form = new UrlForm($this->categoriesQueryResolver, $this->user);
		$form->onSuccess[] = [$this, 'processForm'];
		$form->onValidate[] = [$this, 'validateSignInForm'];
		return $form;
	}

	public function processForm(UrlForm $form, UrlFormValues $values): void
	{
		// Get Identity
		$userId = $this->user->getIdentity()->getId();

		$values = $values->toArray();
		$values['categoryId'] = $values['category'];
		if($values['categoryId'] === 0){ $values['categoryId'] = 0; }
		$values["userId"] = $userId;
		$values["counter"] = 0;
		unset($values['category']);

		$request = CreateUrlRequest::fromArray( $values );

		$this->createUrlMutationResolver->resolveCreateUrl( $request );
		$this->onCreate();
	}

	public function validateSignInForm(UrlForm $form, \stdClass $data): void
	{
		// check exists cbbb in sourceUrl
		if (strpos($data->sourceUrl, 'cbbb.cz') !== false) {
			$form->addError( $data->sourceUrl . ' nelze použít.');
		}

		// check if sourceUrl is unique
		$sourceUrlExistsRequest = new UrlsFilterRequest();
		$sourceUrlExistsRequest->setSourceUrl($data->sourceUrl);
		$sourceUrlExistsCount = $this->urlsQueryResolver->resolveUrls($sourceUrlExistsRequest);

		if( count($sourceUrlExistsCount) > 0){
			$form->addError('Zkrácená url "' . $data->sourceUrl . '" je už obsazená.');
		}

	}

	public function render(): void
	{

		$this->getTemplate()->rootUrl = $this->httpRequest->getUrl()->getBaseUrl();

		$this->getTemplate()->setFile(__DIR__ . '/templates/createUrl.latte');
		$this->getTemplate()->render();
	}

}
