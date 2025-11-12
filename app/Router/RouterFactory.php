<?php declare(strict_types = 1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;

final class RouterFactory
{

	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$adminRouter = new RouteList('Admin');
		$adminRouter->addRoute('admin/<presenter>/<action>[/<id>]', 'Homepage:default');

		$frontRouter = new RouteList('Front');
		$frontRouter->addRoute('<slug .+>', 'Url:detail');
		$frontRouter->addRoute('<presenter>/<action>[/<id>]', 'Homepage:default');

		$apiRouter = new RouteList('Api');
		$apiRouter->addRoute('api/v1/<presenter>/<action>[/<id>]', 'Url:urls');
		$apiRouter->addRoute('api/metadata/', 'Metadata:metadata');

		$router = new RouteList();
		$router->add($adminRouter);
		$router->add($apiRouter);
		$router->add($frontRouter);

		return $router;
	}

}
