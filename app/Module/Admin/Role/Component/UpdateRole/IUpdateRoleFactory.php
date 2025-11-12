<?php declare(strict_types = 1);

namespace App\Module\Admin\Role\Component\UpdateRole;

use App\Model\Database\Entity\Role;

interface IUpdateRoleFactory
{

	public function create(Role $role): UpdateRole;

}
