<?php declare(strict_types = 1);

namespace App\Module\Front\Component\GTM;

interface IGTMFactory
{

	public function create(): GTM;

}
