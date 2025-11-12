<?php declare(strict_types = 1);

namespace App\Module\Front\Component\Footer;

use Nette\Application\UI\Control;

final class Footer extends Control
{

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . "/templates/footer.latte");
		$this->getTemplate()->render();
	}

}
