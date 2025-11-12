<?php declare(strict_types = 1);

namespace App\Module\Admin\User\Component\UpdateUser;

use App\Model\Database\Entity\User;
use App\Model\Resolver\Mutation\User\IUpdateUserMutationResolver;
use App\Model\Resolver\Query\Roles\IRolesQueryResolver;
use App\Model\Resolver\Query\Users\IUsersQueryResolver;
use App\Model\Type\InputObjectType\User\UpdateUserRequest;
use App\Model\Type\InputObjectType\Users\UsersFilterRequest;
use App\Module\Admin\User\Component\UserForm\UserForm;
use App\Module\Admin\User\Component\UserForm\UserFormValues;
use Nette\Application\UI\Control;

final class UpdateUser extends Control
{

	/** @var array<int, callable> */
	public array $onUpdate = [];
	private User $user;
	private IUpdateUserMutationResolver $updateUserMutationResolver;
	private IUsersQueryResolver $usersQueryResolver;
	private IRolesQueryResolver $rolesQueryResolver;

	public function __construct(
		User $user,
		IUpdateUserMutationResolver $updateUserMutationResolver,
		IUsersQueryResolver $usersQueryResolver,
		IRolesQueryResolver $rolesQueryResolver,
		)
	{
		$this->user = $user;
		$this->updateUserMutationResolver = $updateUserMutationResolver;
		$this->usersQueryResolver = $usersQueryResolver;
		$this->rolesQueryResolver = $rolesQueryResolver;
	}

	protected function createComponentForm(): UserForm
	{
		$form = new UserForm($this->rolesQueryResolver);
		$form->onRender[] = [$this, 'fillForm'];
		$form->onSuccess[] = [$this, 'processForm'];
		$form->onValidate[] = [$this, 'validateSignInForm'];
		return $form;
	}

	public function fillForm(UserForm $form): void
	{
		if($this->user->getRole() !== null){
			$form->setDefaults(['role' => $this->user->getRole()->getId()]);
		}

		$form->setDefaults([
			'id' => $this->user->getId(),
			'firstname' => $this->user->getFirstname(),
			'lastname' => $this->user->getLastname(),
			'email' => $this->user->getEmail(),
			'username' => $this->user->getUsername(),
		]);
	}

	public function processForm(UserForm $form, UserFormValues $values): void
	{
		$values = $values->toArray();
		$values['roleId'] = $values['role'];
		if($values['roleId'] === 0){ $values['roleId'] = 0; }
		unset($values['role']);

		$request = UpdateUserRequest::fromArray( $values );
		$this->updateUserMutationResolver->resolveUpdateUser( $this->user, $request );
		$this->onUpdate();

	}

	public function validateSignInForm(UserForm $form, \stdClass $data): void
	{
		// check exists username
		$usernameExistsRequest = new UsersFilterRequest();
		$usernameExistsRequest->setUsername($data->username);
		$usernameExistsRequest->setNotId($this->user->getId());
		$usernameExistsCount = $this->usersQueryResolver->resolveUsers($usernameExistsRequest);

		if( count($usernameExistsCount) > 0){
			$form->addError('Uživatelské jméno ' . $data->username . ' je už obsazené.');
		}

		// check exists email
		$emailExistsRequest = new UsersFilterRequest();
		$emailExistsRequest->setEmail($data->email);
		$emailExistsRequest->setNotId($this->user->getId());
		$emailExistsCount = $this->usersQueryResolver->resolveUsers($emailExistsRequest);

		if( count($emailExistsCount) > 0){
			$form->addError('E-mail "' . $data->email . '" je už obsazený.');
		}
	}

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . '/templates/updateUser.latte');
		$this->getTemplate()->render();
	}

}
