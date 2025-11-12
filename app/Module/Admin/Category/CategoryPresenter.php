<?php declare(strict_types = 1);

namespace App\Module\Admin\Category;

use App\Model\Database\Entity\Category;
use App\Model\Resolver\Mutation\Category\IRemoveCategoryMutationResolver;
use App\Model\Resolver\Query\Categories\ICategoriesQueryResolver;
use App\Model\Resolver\Query\Category\ICategoryQueryResolver;
use App\Model\Resolver\Query\Urls\IUrlsQueryResolver;
use App\Model\Type\InputObjectType\Category\CategoryRequest;
use App\Model\Type\InputObjectType\Category\RemoveCategoryRequest;
use App\Model\Type\InputObjectType\Urls\UrlsFilterRequest;
use App\Model\UI\FlashMessage;
use App\Module\Admin\AdminPresenter;
use App\Module\Admin\Category\Component\CreateCategory\CreateCategory;
use App\Module\Admin\Category\Component\CreateCategory\ICreateCategoryFactory;
use App\Module\Admin\Category\Component\UpdateCategory\IUpdateCategoryFactory;
use App\Module\Admin\Category\Component\UpdateCategory\UpdateCategory;
use Nette\InvalidStateException;
use Nette\Utils\Paginator;

final class CategoryPresenter extends AdminPresenter
{

	private ?Category $category = null;
	private ICreateCategoryFactory $createCategoryFactory;
	private IUpdateCategoryFactory $updateCategoryFactory;
	private IRemoveCategoryMutationResolver $removeCategoryFactory;
	private ICategoryQueryResolver $categoryQueryResolver;
	private ICategoriesQueryResolver $categoriesQueryResolver;
	private IUrlsQueryResolver $urlsQueryResolver;

	public function __construct(
		ICreateCategoryFactory $createCategoryFactory,
		IUpdateCategoryFactory $updateCategoryFactory,
		IRemoveCategoryMutationResolver $removeCategoryFactory,
		ICategoriesQueryResolver $categoriesQueryResolver,
		ICategoryQueryResolver $categoryQueryResolver,
		IUrlsQueryResolver $urlsQueryResolver,
	)
	{
		parent::__construct();
		$this->createCategoryFactory = $createCategoryFactory;
		$this->updateCategoryFactory = $updateCategoryFactory;
		$this->removeCategoryFactory = $removeCategoryFactory;
		$this->categoriesQueryResolver = $categoriesQueryResolver;
		$this->categoryQueryResolver = $categoryQueryResolver;
		$this->urlsQueryResolver = $urlsQueryResolver;
	}

	public function actionDefault(int $page = 1): void
	{
		// Identity
		$userId = $this->getUser()->getIdentity()->getId();

		// Paginator
		$requestCategoryCount = new CategoryRequest();
		$requestCategoryCount->setUserId($userId);
		$categoryCount = $this->categoriesQueryResolver->resolveCategories($requestCategoryCount);
		$this->getTemplate()->categoryCount = $categoryCount;

		$paginator = new Paginator();
		$paginator->setItemCount((int) count($categoryCount));
		$paginator->setItemsPerPage(10);
		$paginator->setPage($page);
		$this->getTemplate()->paginator = $paginator;

		// Category
		$requestCategory = new CategoryRequest();
		$requestCategory->setUserId($userId);
		$requestCategory->setLimit($paginator->getLength());
		$requestCategory->setOffset($paginator->getOffset());
		$this->getTemplate()->categories = $this->categoriesQueryResolver->resolveCategories($requestCategory);

	}

	public function actionDetail(int $id): void
	{
		// Identity
		$userId = $this->getUser()->getIdentity()->getId();

		$request = new CategoryRequest();
		$request->setUserId($userId);
		$request->setId((int)($this->getParameter('id')));

		$category = $this->categoryQueryResolver->resolveCategory($request);

		if ($category === null) {
			$this->error("Kategorie nebyla nalezena, nebo nemáte patřičná práva pro zobrazení.");
		}

		$this->getTemplate()->category = $category;

	}

	public function actionUpdate(int $id): void
	{
		// Identity
		$userId = $this->getUser()->getIdentity()->getId();

		// Check if category author is logged user
		$isCategoryAuthorRequest = new CategoryRequest();
		$isCategoryAuthorRequest->setId($id);
		$isCategoryAuthor = $this->categoryQueryResolver->resolveCategory($isCategoryAuthorRequest);

		if( $isCategoryAuthor->getUser()->getId() !== $userId){

			$this->flashMessage("Nemáte práva upravovat kategorii.", FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		}

		$this->loadCategory();
	}

	protected function createComponentCreateCategory(): CreateCategory
	{
		$component = $this->createCategoryFactory->create();
		$component->onCreate[] = function (): void {
			$this->flashMessage('Kategorie byla vytvořena', FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		};
		return $component;

	}

	protected function createComponentUpdateCategory(): UpdateCategory
	{
		$component = $this->updateCategoryFactory->create($this->getCategory());
		$component->onUpdate[] = function (): void {
			$this->flashMessage('Kategorie byla upravena', FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		};
		return $component;
	}

	private function loadCategory(): Category
	{
		$request = new CategoryRequest();
		$request->setId((int)($this->getParameter('id')));
		$category = $this->categoryQueryResolver->resolveCategory($request);

		if ($category === null) {
			$this->flashMessage('Kategorie nenalezena');
			$this->redirect('default');
		}

		return $this->category = $category;
	}

	private function getCategory(): Category
	{
		if ($this->category === null) {
			throw new InvalidStateException();
		}
		return $this->category;
	}

	public function handleRemoveCategory(int $id): void
	{
		// Identity
		$userId = $this->getUser()->getIdentity()->getId();

		// Check if category author is logged user
		$isCategoryAuthorRequest = new CategoryRequest();
		$isCategoryAuthorRequest->setId($id);
		$isCategoryAuthor = $this->categoryQueryResolver->resolveCategory($isCategoryAuthorRequest);

		if( $isCategoryAuthor->getUser()->getId() !== $userId){

			$this->flashMessage("Nemáte práva smazat kategorii.", FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		}

		// Is Category used?
		$isCategoryRequest = new UrlsFilterRequest();
		$isCategoryRequest->setCategoryId($id);
		$isCategoryUsed = $this->urlsQueryResolver->resolveUrls($isCategoryRequest);

		// Remove Category
		$categoryRemoveRequest = new RemoveCategoryRequest();
		$categoryRemoveRequest->setId($id);

		if(count($isCategoryUsed) === 0) {
			$this->removeCategoryFactory->resolveRemoveCategory($categoryRemoveRequest);
			$this->flashMessage("Kategorie byla smazána.", FlashMessage::TYPE_SUCCESS);
			$this->redirect('default');
		} else {
			$this->flashMessage("Kategorie je používaná a proto ji nelze smazat.", FlashMessage::TYPE_DANGER);
			$this->redirect('default');
		}

	}

}
