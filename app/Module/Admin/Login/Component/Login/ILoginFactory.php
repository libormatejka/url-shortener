<?php declare(strict_types = 1);

namespace App\Module\Admin\Login\Component\Login;

interface ILoginFactory
{

	public function create(): Login;

}
