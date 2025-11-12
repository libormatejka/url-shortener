<?php declare(strict_types = 1);

namespace App\Module\Front\Component\Favicons;

interface IFaviconsFactory
{

	public function create(): Favicons;

}
