<?php declare(strict_types = 1);

namespace App\Module\Admin\User\Component\UpdateUser;

use App\Model\Database\Entity\User;

interface IUpdateUserFactory
{

	public function create(User $user): UpdateUser;

}
