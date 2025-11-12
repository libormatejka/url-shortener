<?php declare(strict_types = 1);

namespace App\Module\Admin\Login;

use App\Model\UI\FlashMessage;
use App\Module\Admin\Login\Component\Login\ILoginFactory;
use App\Module\Admin\Login\Component\Login\Login;
use App\Module\Front\Component\Assets\Assets;
use App\Module\Front\Component\Assets\IAssetsFactory;
use App\Module\Front\Component\Favicons\Favicons;
use App\Module\Front\Component\Favicons\IFaviconsFactory;
use App\Module\Front\Component\Footer\Footer;
use App\Module\Front\Component\Footer\IFooterFactory;
use App\Module\Front\Component\GTM\GTM;
use App\Module\Front\Component\GTM\IGTMFactory;
use Nette\Application\UI\Presenter;

final class LoginPresenter extends Presenter
{

	private ILoginFactory $loginFactory;
	private IFooterFactory $footerFactory;
	private IGTMFactory $gtmFactory;
	private IFaviconsFactory $faviconsFactory;
	private IAssetsFactory $assetsFactory;

	public function __construct(ILoginFactory $loginFactory)
	{
		parent::__construct();
		$this->loginFactory = $loginFactory;
	}

	public function injectFooterFactory(IFooterFactory $footerFactory): void
	{
		$this->footerFactory = $footerFactory;
	}

	public function injectGTMFactory(IGTMFactory $gtmFactory): void
	{
		$this->gtmFactory = $gtmFactory;
	}

	public function injectFaviconsFactory(IFaviconsFactory $faviconsFactory): void
	{
		$this->faviconsFactory = $faviconsFactory;
	}

	public function injectAssetsFactory(IAssetsFactory $assetsFactory): void
	{
		$this->assetsFactory = $assetsFactory;
	}

	protected function createComponentFooter(): Footer
	{
		return $this->footerFactory->create();
	}

	protected function createComponentGTM(): GTM
	{
		return $this->gtmFactory->create();
	}

	protected function createComponentFavicons(): Favicons
	{
		return $this->faviconsFactory->create();
	}

	public function actionDefault(): void
	{
	}

	protected function startup(): void
	{
		parent::startup();
		if ($this->getUser()->isLoggedIn()) {
			$this->redirect(':Admin:Homepage:');
		}
	}

	protected function createComponentLogin(): Login
	{
		$component = $this->loginFactory->create();
		$component->onLogin[] = function (): void {
			$this->flashMessage('Přihlášení bylo úspěšné', FlashMessage::TYPE_SUCCESS);
			$this->redirect(':Admin:Homepage:');
		};
		return $component;
	}

	protected function createComponentAssets(): Assets
	{
		return $this->assetsFactory->create();
	}

}
