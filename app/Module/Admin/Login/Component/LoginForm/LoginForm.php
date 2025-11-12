<?php declare(strict_types = 1);

namespace App\Module\Admin\Login\Component\LoginForm;

use Nette\Application\UI\Form;

final class LoginForm extends Form
{

	public function __construct()
	{
		parent::__construct();
		$this->addText('email')
			->setRequired('Zadejte e-mail.');

		$this->addPassword('password')
			->setRequired('Zadejte heslo.');

		$this->addSubmit('send');

	}

}
