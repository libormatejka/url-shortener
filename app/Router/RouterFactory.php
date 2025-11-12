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

		$router = new RouteList();
		$router->add($adminRouter);
		$router->add($frontRouter);

		return $router;
	}

}
