<?php declare(strict_types = 1);

namespace App\Module\Front;

use Nette\Bridges\ApplicationLatte\Template;
use stdClass;

abstract class FrontTemplate extends Template
{

	public string $basePath;
	public bool $isLoggedIn;
	public ?string $adminLink = null;

	/** @var array<int, stdClass> */
	public array $flashes = [];

}
