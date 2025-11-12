<?php declare(strict_types = 1);

namespace App\Module\Front\Component\Assets;

use Nette\Application\UI\Control;

final class Assets extends Control
{

	public ?float $cssVersion;
	public ?float $jsVersion;

	public function __construct(?float $cssVersion, ?float $jsVersion)
	{
		$this->cssVersion = $cssVersion;
		$this->jsVersion = $jsVersion;
	}

	public function renderCss(): void
	{
		$this->getTemplate()->cssVersion = $this->cssVersion;
		$this->getTemplate()->setFile(__DIR__ . "/templates/css.latte");
		$this->getTemplate()->render();
	}

	public function renderJs(): void
	{
		$this->getTemplate()->jsVersion = $this->jsVersion;
		$this->getTemplate()->setFile(__DIR__ . "/templates/js.latte");
		$this->getTemplate()->render();
	}

}
