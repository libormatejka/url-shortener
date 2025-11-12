<?php declare(strict_types = 1);

namespace App\Module\Admin\Profile;

use App\Model\Resolver\Query\Urls\IUrlsQueryResolver;
use App\Model\Resolver\Query\User\IUserQueryResolver;
use App\Model\Type\InputObjectType\Urls\UrlsFilterRequest;
use App\Model\Type\InputObjectType\User\UserFilterRequest;
use App\Module\Admin\AdminPresenter;

final class ProfilePresenter extends AdminPresenter
{

	private IUserQueryResolver $userQueryResolver;
	private IUrlsQueryResolver $urlsQueryResolver;

	public function __construct(
		IUserQueryResolver $userQueryResolver,
		IUrlsQueryResolver $urlsQueryResolver,
	)
	{
		parent::__construct();
		$this->userQueryResolver = $userQueryResolver;
		$this->urlsQueryResolver = $urlsQueryResolver;
	}

	public function actionDefault(): void
	{
		$userId = $this->getUser()->getIdentity()->getId();
		$request = new UserFilterRequest();
		$request->setId((int)($userId));

		// Get URLs Count
		$requestUrlCount = new UrlsFilterRequest();
		$requestUrlCount->setUserId((int)($userId));

		// Get Counter Sum
		$requestSumCounter = new UrlsFilterRequest();
		$requestSumCounter->setUserId($userId);

		$this->getTemplate()->userData = $this->userQueryResolver->resolveUser($request);
		$this->getTemplate()->urls = $this->urlsQueryResolver->resolveUrls($requestUrlCount);

		if($this->urlsQueryResolver->resolveSumUrl($requestSumCounter) === null){
			$this->getTemplate()->sumCounter = 0;
		}else{
			$this->getTemplate()->sumCounter = $this->urlsQueryResolver->resolveSumUrl($requestSumCounter);
		}

	}

}
