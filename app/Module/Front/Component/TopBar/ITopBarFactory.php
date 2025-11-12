<?php declare(strict_types = 1);

namespace App\Module\Front\Component\TopBar;

interface ITopBarFactory
{

	public function create(): TopBar;

}
