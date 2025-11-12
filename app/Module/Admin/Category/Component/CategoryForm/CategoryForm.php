<?php declare(strict_types = 1);

namespace App\Module\Admin\Category\Component\CategoryForm;

use Nette\Application\UI\Form;

final class CategoryForm extends Form
{

	public function __construct()
	{
		parent::__construct();

		$this->addText('title')
			->setRequired(true);

		$this->addText('slug')
			->setRequired(true);

		$this->addSubmit('send');

	}

}
