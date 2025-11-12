<?php declare(strict_types = 1);

namespace App\Module\Admin\Url\Component\CreateUrl;

interface ICreateUrlFactory
{

	public function create(): CreateUrl;

}
