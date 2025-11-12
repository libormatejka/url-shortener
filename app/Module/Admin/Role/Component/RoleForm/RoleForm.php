<?php declare(strict_types = 1);

namespace App\Module\Admin\Role\Component\RoleForm;

use Nette\Application\UI\Form;

final class RoleForm extends Form
{

	public function __construct()
	{
		parent::__construct();

		$this->addText('name')
			->setRequired(true);

		$this->addSubmit('send');

	}

}
