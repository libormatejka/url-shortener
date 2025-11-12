<?php declare(strict_types = 1);

namespace App\Module\Admin;

use App\Model\Resolver\Mutation\Logout\LogoutMutationResolver;
use App\Model\UI\FlashMessage;
use App\Module\Front\Component\Assets\Assets;
use App\Module\Front\Component\Assets\IAssetsFactory;
use App\Module\Front\Component\Favicons\Favicons;
use App\Module\Front\Component\Favicons\IFaviconsFactory;
use App\Module\Front\Component\Footer\Footer;
use App\Module\Front\Component\Footer\IFooterFactory;
use App\Module\Front\Component\GTM\GTM;
use App\Module\Front\Component\GTM\IGTMFactory;
use Nette\Application\UI\Presenter;

abstract class AdminPresenter extends Presenter
{

	private LogoutMutationResolver $logoutMutationResolver;
	private IFooterFactory $footerFactory;
	private IGTMFactory $gtmFactory;
	private IFaviconsFactory $faviconsFactory;
	private IAssetsFactory $assetsFactory;

	public function injectLogoutMutationResolver( LogoutMutationResolver $logoutMutationResolver ): void
	{

		parent::__construct();
		$this->logoutMutationResolver = $logoutMutationResolver;

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

	protected function startup(): void
	{
		parent::startup();
		if (!$this->getUser()->isLoggedIn()) {
			$this->redirect(':Admin:Login:');
		}
	}

	protected function createComponentAssets(): Assets
	{
		return $this->assetsFactory->create();
	}

	public function handleLogout(): void
	{
		$this->logoutMutationResolver->resolveLogout();
		$this->flashMessage("Byl jste odhlášen", FlashMessage::TYPE_SUCCESS );
		$this->redirect('default');
	}

}
