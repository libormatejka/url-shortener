<?php declare(strict_types = 1);

namespace App\Module\Admin\Role\Component\RoleForm;

use Nette\Application\UI\Control;

final class RoleFormValues extends Control
{

	public string $name;

	/**
	 * @return array{name: string}
	 */
	public function toArray(): array
	{
		return ["name" => $this->name];
	}

}
