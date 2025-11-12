<?php declare(strict_types = 1);

namespace App\Module\Front;

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
use App\Module\Front\Component\TopBar\ITopBarFactory;
use App\Module\Front\Component\TopBar\TopBar;
use Nette\Application\UI\Presenter;

abstract class FrontPresenter extends Presenter
{

	private ITopBarFactory $topBarFactory;
	private IFooterFactory $footerFactory;
	private ILoginFactory $loginFactory;
	private IGTMFactory $gtmFactory;
	private IFaviconsFactory $faviconsFactory;
	private IAssetsFactory $assetsFactory;

	protected function startup(): void
	{
		parent::startup();
		$this->getTemplate()->adminLink = null;
		$this->getTemplate()->isLoggedIn = $this->getUser()->isLoggedIn();
	}

	public function injectTopBarFactory(ITopBarFactory $topBarFactory): void
	{
		$this->topBarFactory = $topBarFactory;
	}

	public function injectFooterFactory(IFooterFactory $footerFactory): void
	{
		$this->footerFactory = $footerFactory;
	}

	public function injectLoginFactory(ILoginFactory $loginFactory): void
	{
		$this->loginFactory = $loginFactory;
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

	protected function createComponentTopBar(): TopBar
	{
		return $this->topBarFactory->create();
	}

	protected function createComponentFooter(): Footer
	{
		return $this->footerFactory->create();
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

	protected function createComponentGTM(): GTM
	{
		return $this->gtmFactory->create();
	}

	protected function createComponentFavicons(): Favicons
	{
		return $this->faviconsFactory->create();
	}

	protected function createComponentAssets(): Assets
	{
		return $this->assetsFactory->create();
	}

}
