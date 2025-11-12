<?php declare(strict_types = 1);

namespace App\Module\Admin\Role\Component\UpdateRole;

use App\Model\Database\Entity\Role;
use App\Model\Resolver\Mutation\Role\IUpdateRoleMutationResolver;
use App\Model\Resolver\Query\Roles\IRolesQueryResolver;
use App\Model\Type\InputObjectType\Role\UpdateRoleRequest;
use App\Model\Type\InputObjectType\Roles\RolesFilterRequest;
use App\Module\Admin\Role\Component\RoleForm\RoleForm;
use App\Module\Admin\Role\Component\RoleForm\RoleFormValues;
use Nette\Application\UI\Control;

final class UpdateRole extends Control
{

	/** @var array<int, callable> */
	public array $onUpdate = [];
	private Role $role;
	private IUpdateRoleMutationResolver $updateRoleMutationResolver;
	private IRolesQueryResolver $rolesQueryResolver;

	public function __construct(
		Role $role,
		IUpdateRoleMutationResolver $updateRoleMutationResolver,
		IRolesQueryResolver $rolesQueryResolver,
	)
	{
		$this->role = $role;
		$this->updateRoleMutationResolver = $updateRoleMutationResolver;
		$this->rolesQueryResolver = $rolesQueryResolver;
	}

	protected function createComponentForm(): RoleForm
	{
		$form = new RoleForm();
		$form->onRender[] = [$this, 'fillForm'];
		$form->onSuccess[] = [$this, 'processForm'];
		$form->onValidate[] = [$this, 'validateSignInForm'];
		return $form;
	}

	public function fillForm(RoleForm $form): void
	{
		$form->setDefaults([
			'name' => $this->role->getName(),
		]);
	}

	public function processForm(RoleForm $form, RoleFormValues $values): void
	{
		$request = UpdateRoleRequest::fromArray( $values->toArray() );
		$this->updateRoleMutationResolver->resolveUpdateRole( $this->role, $request );
		$this->onUpdate();

	}

	public function validateSignInForm(RoleForm $form, \stdClass $data): void
	{
		// check if name is unique
		$roleSlugExistsRequest = new RolesFilterRequest();
		$roleSlugExistsRequest->setName($data->name);
		$roleSlugExistsCount = $this->rolesQueryResolver->resolveRoles($roleSlugExistsRequest);

		if( count($roleSlugExistsCount) > 0){
			$form->addError('Jméno "' . $data->name . '" je už obsazený.');
		}

	}

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . '/templates/updateRole.latte');
		$this->getTemplate()->render();
	}

}
