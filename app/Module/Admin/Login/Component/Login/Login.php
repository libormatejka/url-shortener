<?php declare(strict_types = 1);

namespace App\Module\Admin\Login\Component\Login;

use App\Model\Resolver\Mutation\Login\ILoginMutationResolver;
use App\Model\Type\InputObjectType\Login\LoginRequest;
use App\Module\Admin\Login\Component\LoginForm\LoginForm;
use App\Module\Admin\Login\Component\LoginForm\LoginFormValues;
use Nette\Application\UI\Control;

final class Login extends Control
{

	/** @var array<int, callable> */
	public array $onLogin = [];
	private ILoginMutationResolver $loginMutationResolver;

	public function __construct(ILoginMutationResolver $LoginMutationResolver)
	{
		$this->loginMutationResolver = $LoginMutationResolver;
	}

	protected function createComponentForm(): LoginForm
	{
		$form = new LoginForm();
		$form->onSuccess[] = [$this, 'processForm'];
		return $form;
	}

	public function processForm(LoginForm $form, LoginFormValues $values): void
	{
		$request = LoginRequest::fromArray($values->toArray());

		try {
			$this->loginMutationResolver->resolveLogin( $request );
			$this->onLogin();
		} catch (\Nette\Security\AuthenticationException $e) {
			$form->addError('Nesprávné přihlašovací jméno nebo heslo.');
		}

	}

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . '/templates/login.latte');
		$this->getTemplate()->render();
	}

}
