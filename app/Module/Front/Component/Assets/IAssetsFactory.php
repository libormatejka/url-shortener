<?php declare(strict_types = 1);

namespace App\Module\Front\Component\Assets;

interface IAssetsFactory
{

	public function create(): Assets;

}
