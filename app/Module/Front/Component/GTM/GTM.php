<?php declare(strict_types = 1);

namespace App\Module\Front\Component\GTM;

use Nette\Application\UI\Control;

final class GTM extends Control
{

	public ?string $gtmId;

	public function __construct(?string $gtmId)
	{
		$this->gtmId = $gtmId;
	}

	public function renderHead(): void
	{
		if($this->gtmId === null){
			return;
		}
		$this->getTemplate()->gtmId = $this->gtmId;
		$this->getTemplate()->setFile(__DIR__ . "/templates/head.latte");
		$this->getTemplate()->render();
	}

	public function renderBody(): void
	{
		if($this->gtmId === null){
			return;
		}
		$this->getTemplate()->gtmId = $this->gtmId;
		$this->getTemplate()->setFile(__DIR__ . "/templates/body.latte");
		$this->getTemplate()->render();
	}

}
