<?php declare(strict_types = 1);

namespace App\Module\Admin\Role\Component\CreateRole;

interface ICreateRoleFactory
{

	public function create(): CreateRole;

}
