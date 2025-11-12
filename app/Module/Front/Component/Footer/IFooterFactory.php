<?php declare(strict_types = 1);

namespace App\Module\Front\Component\Footer;

interface IFooterFactory
{

	public function create(): Footer;

}
