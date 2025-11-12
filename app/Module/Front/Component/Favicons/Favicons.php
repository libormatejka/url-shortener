<?php declare(strict_types = 1);

namespace App\Module\Front\Component\Favicons;

use Nette\Application\UI\Control;

final class Favicons extends Control
{

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . "/templates/favicons.latte");
		$this->getTemplate()->render();
	}

}
