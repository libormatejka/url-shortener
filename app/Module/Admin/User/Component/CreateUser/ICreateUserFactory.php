<?php declare(strict_types = 1);

namespace App\Module\Admin\User\Component\CreateUser;

interface ICreateUserFactory
{

	public function create(): CreateUser;

}
