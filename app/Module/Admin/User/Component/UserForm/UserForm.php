<?php declare(strict_types = 1);

namespace App\Module\Admin\User\Component\UserForm;

use App\Model\Resolver\Query\Roles\IRolesQueryResolver;
use App\Model\Type\InputObjectType\Roles\RolesFilterRequest;
use Nette\Application\UI\Form;

final class UserForm extends Form
{

	private IRolesQueryResolver $rolesQueryResolver;

	public function __construct(IRolesQueryResolver $rolesQueryResolver)
	{
		parent::__construct();
		$this->rolesQueryResolver = $rolesQueryResolver;

		$this->addText('firstname')
			->setRequired(true);

		$this->addText('lastname')
			->setRequired(true);

		$this->addText('username')
			->setRequired(true);

		$this->addEmail('email')
			->setRequired(true);

		$this->addPassword('password')
			->setRequired(true);

		$request = new RolesFilterRequest();
		$roles = $this->rolesQueryResolver->resolveRoles($request);
		$list = [];

		foreach ($roles as $role) {
			$list[$role->getId()] = $role->getName();
		}

		if(count($list) == 0 ){
			$list[0] = "-";
		}

		$this->addSelect('role', 'Role', $list);

		$this->addSubmit('send');

	}

}
