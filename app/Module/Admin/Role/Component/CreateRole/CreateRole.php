<?php declare(strict_types = 1);

namespace App\Module\Admin\Role\Component\CreateRole;

use App\Model\Resolver\Mutation\Role\ICreateRoleMutationResolver;
use App\Model\Resolver\Query\Roles\IRolesQueryResolver;
use App\Model\Type\InputObjectType\Role\CreateRoleRequest;
use App\Model\Type\InputObjectType\Roles\RolesFilterRequest;
use App\Module\Admin\Role\Component\RoleForm\RoleForm;
use App\Module\Admin\Role\Component\RoleForm\RoleFormValues;
use Nette\Application\UI\Control;
use Nette\Security\User;

final class CreateRole extends Control
{

	/** @var array<int, callable> */
	public array $onCreate = [];
	private ICreateRoleMutationResolver $createRoleMutationResolver;
	private IRolesQueryResolver $rolesQueryResolver;
	private User $user;

	public function __construct(
		ICreateRoleMutationResolver $createRoleMutationResolver,
		IRolesQueryResolver $rolesQueryResolver,
		User $user,
	)
	{
		$this->createRoleMutationResolver = $createRoleMutationResolver;
		$this->rolesQueryResolver = $rolesQueryResolver;
		$this->user = $user;
	}

	protected function createComponentForm(): RoleForm
	{
		$form = new RoleForm();
		$form->onSuccess[] = [$this, 'processForm'];
		$form->onValidate[] = [$this, 'validateSignInForm'];
		return $form;
	}

	public function processForm(RoleForm $form, RoleFormValues $values): void
	{
		$values = $values->toArray();

		$request = CreateRoleRequest::fromArray( $values );
		$this->createRoleMutationResolver->resolveCreateRole( $request );
		$this->onCreate();
	}

	public function validateSignInForm(RoleForm $form, \stdClass $data): void
	{
		// check if sourceUrl is unique
		$rolesNameExistsRequest = new RolesFilterRequest();
		$rolesNameExistsRequest->setName($data->name);
		$rolesNameExistsCount = $this->rolesQueryResolver->resolveRoles($rolesNameExistsRequest);

		if( count($rolesNameExistsCount) > 0){
			$form->addError('Název "' . $data->name . '" je už obsazený.');
		}

	}

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . '/templates/createRole.latte');
		$this->getTemplate()->render();
	}

}
