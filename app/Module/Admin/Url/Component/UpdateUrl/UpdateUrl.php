<?php declare(strict_types = 1);

namespace App\Module\Admin\Url\Component\UpdateUrl;

use App\Model\Database\Entity\Url;
use App\Model\Resolver\Mutation\Url\IUpdateUrlMutationResolver;
use App\Model\Resolver\Query\Categories\ICategoriesQueryResolver;
use App\Model\Resolver\Query\Urls\IUrlsQueryResolver;
use App\Model\Type\InputObjectType\Url\UpdateUrlRequest;
use App\Model\Type\InputObjectType\Urls\UrlsFilterRequest;
use App\Module\Admin\Url\Component\UrlForm\UrlForm;
use App\Module\Admin\Url\Component\UrlForm\UrlFormValues;
use Nette\Application\UI\Control;
use Nette\Http\Request;
use Nette\Security\User;

final class UpdateUrl extends Control
{

	/** @var array<int, callable> */
	public array $onUpdate = [];
	private Url $url;
	private ICategoriesQueryResolver $categoriesQueryResolver;
	private IUpdateUrlMutationResolver $updateUrlMutationResolver;
	private User $user;
	private IUrlsQueryResolver $urlsQueryResolver;
	private Request $httpRequest;

	public function __construct(
		Url $url,
		ICategoriesQueryResolver $categoriesQueryResolver,
		IUpdateUrlMutationResolver $updateUrlMutationResolver,
		User $user,
		IUrlsQueryResolver $urlsQueryResolver,
		Request $httpRequest,
		)
	{
		$this->categoriesQueryResolver = $categoriesQueryResolver;
		$this->url = $url;
		$this->updateUrlMutationResolver = $updateUrlMutationResolver;
		$this->user = $user;
		$this->urlsQueryResolver = $urlsQueryResolver;
		$this->httpRequest = $httpRequest;
	}

	protected function createComponentForm(): UrlForm
	{
		$form = new UrlForm($this->categoriesQueryResolver, $this->user);
		$form->onRender[] = [$this, 'fillForm'];
		$form->onSuccess[] = [$this, 'processForm'];
		$form->onValidate[] = [$this, 'validateSignInForm'];
		return $form;
	}

	public function fillForm(UrlForm $form): void
	{
		if($this->url->getCategory() !== null){
			$form->setDefaults(['category' => $this->url->getCategory()->getId()]);
		}

		$form->setDefaults([
			'sourceUrl' => $this->url->getSourceUrl(),
			'destinationUrl' => $this->url->getDestinationUrl(),
			'title' => $this->url->getTitle(),
			'comment' => $this->url->getComment(),
		]);
	}

	public function processForm(UrlForm $form, UrlFormValues $values): void
	{
		$values = $values->toArray();
		$values['categoryId'] = $values['category'];
		if($values['categoryId'] === 0){ $values['categoryId'] = 0; }
		unset($values['category']);

		$request = UpdateUrlRequest::fromArray( $values );
		$this->updateUrlMutationResolver->resolveUpdateUrl( $this->url, $request );
		$this->onUpdate();

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
		$sourceUrlExistsRequest->setNotId($this->url->getId());
		$sourceUrlExistsCount = $this->urlsQueryResolver->resolveUrls($sourceUrlExistsRequest);

		if( count($sourceUrlExistsCount) > 0){
			$form->addError('Zkrácená url "' . $data->sourceUrl . '" je už obsazená.');
		}

	}

	public function render(): void
	{
		$this->getTemplate()->rootUrl = $this->httpRequest->getUrl()->getBaseUrl();

		$this->getTemplate()->setFile(__DIR__ . '/templates/updateUrl.latte');
		$this->getTemplate()->render();
	}

}
