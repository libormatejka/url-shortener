<?php declare(strict_types = 1);

namespace App\Module\Front\Error4xx;

use Nette\Application\BadRequestException;
use Nette\Application\Request;
use Nette\Application\UI\Presenter;

final class Error4xxPresenter extends Presenter
{

	public function startup(): void
	{
		parent::startup();
		$request = $this->getRequest();
		assert($request !== null);
		if (!$request->isMethod(Request::FORWARD)) {
			$this->error();
		}
	}

	public function renderDefault(BadRequestException $exception): void
	{
		// load template Error.403.latte or Error.404.latte or ... Error.4xx.latte
		$file = __DIR__ . "/templates/Error.{$exception->getCode()}.latte";
		$this->getTemplate()->setFile(is_file($file) ? $file : __DIR__ . '/templates/Error.4xx.latte');
	}

}
