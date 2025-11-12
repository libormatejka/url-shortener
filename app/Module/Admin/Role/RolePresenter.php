<?php declare(strict_types = 1);

namespace App\Module\Admin\Role;

use App\Model\Database\Entity\Role;
use App\Model\Resolver\Mutation\Role\IRemoveRoleMutationResolver;
use App\Model\Resolver\Query\Role\IRoleQueryResolver;
use App\Model\Resolver\Query\Roles\IRolesQueryResolver;
use App\Model\Resolver\Query\Users\IUsersQueryResolver;
use App\Model\Type\InputObjectType\Role\RemoveRoleFilterRequest;
use App\Model\Type\InputObjectType\Role\RoleFilterRequest;
use App\Model\Type\InputObjectType\Roles\RolesFilterRequest;
use App\Model\Type\InputObjectType\Users\UsersFilterRequest;
use App\Model\UI\FlashMessage;
use App\Module\Admin\AdminPresenter;
use App\Module\Admin\Role\Component\CreateRole\CreateRole;
use App\Module\Admin\Role\Component\CreateRole\ICreateRoleFactory;
use App\Module\Admin\Role\Component\UpdateRole\IUpdateRoleFactory;
use App\Module\Admin\Role\Component\UpdateRole\UpdateRole;
use Nette\InvalidStateException;
use Nette\Utils\Paginator;

final class RolePresenter extends AdminPresenter
{

	private ?Role $role = null;
	private ICreateRoleFactory $createRoleFactory;
	private IUpdateRoleFactory $updateRoleFactory;
	private IRemoveRoleMutationResolver $removeRoleFactory;
	private IRolesQueryResolver $rolesQueryResolver;
	private IRoleQueryResolver $roleQueryResolver;
	private IUsersQueryResolver $usersQueryResolver;

	public function __construct(
		ICreateRoleFactory $createRoleFactory,
		IUpdateRoleFactory $updateRoleFactory,
		IRemoveRoleMutationResolver $removeRoleFactory,
		IRolesQueryResolver $rolesQueryResolver,
		IRoleQueryResolver $roleQueryResolver,
		IUsersQueryResolver $usersQueryResolver,
	)
	{
		parent::__construct();
		$this->createRoleFactory = $createRoleFactory;
		$this->updateRoleFactory = $updateRoleFactory;
		$this->removeRoleFactory = $removeRoleFactory;
		$this->rolesQueryResolver = $rolesQueryResolver;
		$this->roleQueryResolver = $roleQueryResolver;
		$this->usersQueryResolver = $usersQueryResolver;
	}

	public function actionDefault(int $page = 1): void
	{
		// Paginator
		$requestRolesCount = new RolesFilterRequest();
		$rolesCount = $this->rolesQueryResolver->resolveRoles($requestRolesCount);
		$this->getTemplate()->rolesCount = $rolesCount;

		$paginator = new Paginator();
		$paginator->setItemCount((int) count($rolesCount));
		$paginator->setItemsPerPage(10);
		$paginator->setPage($page);
		$this->getTemplate()->paginator = $paginator;

		// Role
		$requestRoles = new RolesFilterRequest();
		$requestRoles->setLimit($paginator->getLength());
		$requestRoles->setOffset($paginator->getOffset());
		$this->getTemplate()->roles = $this->rolesQueryResolver->resolveRoles($requestRoles);

	}

	public function actionDetail(int $id): void
	{

		$request = new RoleFilterRequest();
		$request->setId((int)($this->getParameter('id')));

		$role = $this->roleQueryResolver->resolveRole($request);

		if ($role === null) {
			$this->error("Role nebyla nalezena, nebo nemáte patřičná práva pro zobrazení.");
		}

		$this->getTemplate()->role = $role;

	}

	public function actionUpdate(int $id): void
	{
		$this->loadRole();
	}

	protected function createComponentCreateRole(): CreateRole
	{
		$component = $this->createRoleFactory->create();
		$component->onCreate[] = function (): void {
			$this->flashMessage('Kategorie byla vytvořena', FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		};
		return $component;

	}

	protected function createComponentUpdateRole(): UpdateRole
	{
		$component = $this->updateRoleFactory->create($this->getRole());
		$component->onUpdate[] = function (): void {
			$this->flashMessage('Kategorie byla upravena', FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		};
		return $component;
	}

	private function loadRole(): Role
	{
		$request = new RoleFilterRequest();
		$request->setId((int)($this->getParameter('id')));
		$role = $this->roleQueryResolver->resolveRole($request);

		if ($role === null) {
			$this->flashMessage('Role nenalezena');
			$this->redirect('default');
		}

		return $this->role = $role;
	}

	private function getRole(): Role
	{
		if ($this->role === null) {
			throw new InvalidStateException();
		}
		return $this->role;
	}

	public function handleRemoveRole(int $id): void
	{
		// Is Role used?
		$isRoleFilterRequest = new UsersFilterRequest();
		$isRoleFilterRequest->setRoleId($id);
		$isRoleUsed = $this->usersQueryResolver->resolveUsers($isRoleFilterRequest);

		// Remove Role
		$roleRemoveRequest = new RemoveRoleFilterRequest();
		$roleRemoveRequest->setId($id);

		if(count($isRoleUsed) === 0) {
			$this->removeRoleFactory->resolveRemoveRole($roleRemoveRequest);
			$this->flashMessage("Role byla smazána.", FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		} else {
			$this->flashMessage("Role je používaná a proto ji nelze smazat.", FlashMessage::TYPE_DANGER);
			$this->redirect('default');
		}

	}

}
