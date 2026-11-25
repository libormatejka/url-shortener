<?php declare(strict_types = 1);

namespace App\Module\Front\Homepage;

use Clown\Core\Admin\Login\Component\Login\ILoginFactory;
use Clown\Core\Admin\Login\Component\Login\Login;
use Clown\Core\Front\FrontPresenter;
use Clown\Core\Settings\WebTitle;

/**
 * Homepage webu: pouze přihlašovací formulář pod názvem webu.
 */
class HomepagePresenter extends FrontPresenter
{

	public function __construct(
		private ILoginFactory $loginFactory,
		private WebTitle $webTitle,
	)
	{
		parent::__construct();
	}

	public function actionDefault(): void
	{
		if ($this->getUser()->isLoggedIn()) {
			$this->redirect(':Admin:Homepage:');
		}

		$this->setLayout('layoutLogin');
		$this->getMetaTags()->setTitle((string) $this->webTitle);
		$this->template->webTitle = (string) $this->webTitle;
	}

	protected function createComponentLogin(): Login
	{
		$component = $this->loginFactory->create();
		$component->onLogin[] = function (): void {
			$this->redirect(':Admin:Homepage:');
		};
		return $component;
	}

}
