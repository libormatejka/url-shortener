<?php declare(strict_types = 1);

namespace App\Module\Admin\User;

use App\Model\Database\Entity\User;
use App\Model\Resolver\Mutation\User\IRemoveUserMutationResolver;
use App\Model\Resolver\Query\Role\IRoleQueryResolver;
use App\Model\Resolver\Query\User\IUserQueryResolver;
use App\Model\Resolver\Query\Users\IUsersQueryResolver;
use App\Model\Type\InputObjectType\User\RemoveUserRequest;
use App\Model\Type\InputObjectType\User\UserFilterRequest;
use App\Model\Type\InputObjectType\Users\UsersFilterRequest;
use App\Model\UI\FlashMessage;
use App\Module\Admin\AdminPresenter;
use App\Module\Admin\User\Component\CreateUser\CreateUser;
use App\Module\Admin\User\Component\CreateUser\ICreateUserFactory;
use App\Module\Admin\User\Component\UpdateUser\IUpdateUserFactory;
use App\Module\Admin\User\Component\UpdateUser\UpdateUser;
use Nette\InvalidStateException;
use Nette\Utils\Paginator;

final class UserPresenter extends AdminPresenter
{

	private ?User $user = null;
	private ICreateUserFactory $createUserFactory;
	private IUpdateUserFactory $updateUserFactory;
	private IRemoveUserMutationResolver $removeUserFactory;
	private IUsersQueryResolver $usersQueryResolver;
	private IUserQueryResolver $userQueryResolver;
	private IRoleQueryResolver $roleQueryResolver;

	public function __construct(
		ICreateUserFactory $createUserFactory,
		IUpdateUserFactory $updateUserFactory,
		IRemoveUserMutationResolver $removeUserFactory,
		IUsersQueryResolver $usersQueryResolver,
		IUserQueryResolver $userQueryResolver,
		IRoleQueryResolver $roleQueryResolver,
	)
	{
		parent::__construct();
		$this->createUserFactory = $createUserFactory;
		$this->updateUserFactory = $updateUserFactory;
		$this->removeUserFactory = $removeUserFactory;
		$this->usersQueryResolver = $usersQueryResolver;
		$this->userQueryResolver = $userQueryResolver;
		$this->roleQueryResolver = $roleQueryResolver;
	}

	protected function createComponentCreateUser(): CreateUser
	{
		$component = $this->createUserFactory->create();
		$component->onCreate[] = function (): void {
			$this->flashMessage('Uživatel byl vytvořen', FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		};
		return $component;

	}

	protected function createComponentUpdateUser(): UpdateUser
	{
		$component = $this->updateUserFactory->create($this->getUserData());
		$component->onUpdate[] = function (): void {
			$this->flashMessage('Uživatel byl upraven', FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		};
		return $component;
	}

	public function actionDefault(int $page = 1): void
	{
		// Paginator
		$requestUserCount = new UsersFilterRequest();
		$userCount = $this->usersQueryResolver->resolveUsers($requestUserCount);
		$this->getTemplate()->userCount = $userCount;

		$paginator = new Paginator();
		$paginator->setItemCount((int) count($userCount));
		$paginator->setItemsPerPage(10);
		$paginator->setPage($page);
		$this->getTemplate()->paginator = $paginator;

		// URLs
		$requestUser = new UsersFilterRequest();
		$requestUser->setLimit($paginator->getLength());
		$requestUser->setOffset($paginator->getOffset());
		$this->getTemplate()->users = $this->usersQueryResolver->resolveUsers($requestUser);
	}

	public function actionDetail(int $id): void
	{
		$request = new UserFilterRequest();
		$request->setId((int)($this->getParameter('id')));
		$this->getTemplate()->userData = $this->userQueryResolver->resolveUser($request);

	}

	public function actionUpdate(int $id): void
	{
		$this->loadUserData();
	}

	private function getUserData(): User
	{
		if ($this->user === null) {
			throw new InvalidStateException();
		}
		return $this->user;
	}

	public function loadUserData(): User
	{
		$request = new UserFilterRequest();
		$request->setId((int)($this->getParameter('id')));
		$user = $this->userQueryResolver->resolveUser($request);

		if ($user === null) {
			$this->flashMessage('Uživatel nenalezen');
			$this->redirect('default');
		}
		return $this->user = $user;
	}

	public function handleRemoveUser(int $id): void
	{
		$request = RemoveUserRequest::fromArray(["id" => $id]);

		$userId = $this->getUser()->getIdentity()->getId();

		if( $userId == $id ){
			$this->flashMessage("Nemůžete smazat vlastní profil", FlashMessage::TYPE_DANGER );
			$this->redirect('default');
		}

		$this->removeUserFactory->resolveRemoveUser( $request );

		$this->flashMessage("Uživatel s ID: " . $id . " byl úspěšně smazán.", FlashMessage::TYPE_SUCCESS );
		$this->redirect('default');

	}

}
