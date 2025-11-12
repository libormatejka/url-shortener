<?php declare(strict_types = 1);

namespace App\Module\Admin\User\Component\CreateUser;

use App\Model\Resolver\Mutation\User\ICreateUserMutationResolver;
use App\Model\Resolver\Query\Roles\IRolesQueryResolver;
use App\Model\Resolver\Query\Users\IUsersQueryResolver;
use App\Model\Type\InputObjectType\User\CreateUserRequest;
use App\Model\Type\InputObjectType\Users\UsersFilterRequest;
use App\Module\Admin\User\Component\UserForm\UserForm;
use App\Module\Admin\User\Component\UserForm\UserFormValues;
use Nette\Application\UI\Control;

final class CreateUser extends Control
{

	/** @var array<int, callable> */
	public array $onCreate = [];
	private ICreateUserMutationResolver $createUserMutationResolver;
	private IUsersQueryResolver $usersQueryResolver;
	private IRolesQueryResolver $rolesQueryResolver;

	public function __construct(
		ICreateUserMutationResolver $createUserMutationResolver,
		IUsersQueryResolver $usersQueryResolver,
		IRolesQueryResolver $rolesQueryResolver,
		)
	{
		$this->createUserMutationResolver = $createUserMutationResolver;
		$this->usersQueryResolver = $usersQueryResolver;
		$this->rolesQueryResolver = $rolesQueryResolver;
	}

	protected function createComponentForm(): UserForm
	{
		$form = new UserForm($this->rolesQueryResolver);
		$form->onSuccess[] = [$this, 'processForm'];
		$form->onValidate[] = [$this, 'validateSignInForm'];
		return $form;
	}

	public function processForm(UserForm $form, UserFormValues $values): void
	{
		$values = $values->toArray();
		$values['roleId'] = $values['role'];
		if($values['roleId'] === 0){ $values['roleId'] = 0; }
		unset($values['role']);

		$request = CreateUserRequest::fromArray( $values );
		$this->createUserMutationResolver->resolveCreateUser( $request );
		$this->onCreate();
	}

	public function validateSignInForm(UserForm $form, \stdClass $data): void
	{
		// check exists username
		$usernameExistsRequest = new UsersFilterRequest();
		$usernameExistsRequest->setUsername($data->username);
		$usernameExistsCount = $this->usersQueryResolver->resolveUsers($usernameExistsRequest);

		if( count($usernameExistsCount) > 0){
			$form->addError('Uživatelské jméno ' . $data->username . ' je už obsazené.');
		}

		// check exists email
		$emailExistsRequest = new UsersFilterRequest();
		$emailExistsRequest->setEmail($data->email);
		$emailExistsCount = $this->usersQueryResolver->resolveUsers($emailExistsRequest);

		if( count($emailExistsCount) > 0){
			$form->addError('E-mail "' . $data->email . '" je už obsazený.');
		}
	}

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . '/templates/createUser.latte');
		$this->getTemplate()->render();
	}

}
