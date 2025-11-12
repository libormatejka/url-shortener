<?php declare(strict_types = 1);

namespace App\Module\Front\Component\TopBar;

use Nette\Application\UI\Control;

final class TopBar extends Control
{

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . "/templates/topBar.latte");
		$this->getTemplate()->render();
	}

}
