<?php declare(strict_types = 1);

namespace App\Module\Admin\Category\Component\CreateCategory;

use App\Model\Resolver\Mutation\Category\ICreateCategoryMutationResolver;
use App\Model\Resolver\Query\Categories\ICategoriesQueryResolver;
use App\Model\Type\InputObjectType\Category\CategoryRequest;
use App\Model\Type\InputObjectType\Category\CreateCategoryRequest;
use App\Module\Admin\Category\Component\CategoryForm\CategoryForm;
use App\Module\Admin\Category\Component\CategoryForm\CategoryFormValues;
use Nette\Application\UI\Control;
use Nette\Security\User;

final class CreateCategory extends Control
{

	/** @var array<int, callable> */
	public array $onCreate = [];
	private ICreateCategoryMutationResolver $createCategoryMutationResolver;
	private ICategoriesQueryResolver $categoriesQueryResolver;
	private User $user;

	public function __construct(
		ICreateCategoryMutationResolver $createCategoryMutationResolver,
		ICategoriesQueryResolver $categoriesQueryResolver,
		User $user,
	)
	{
		$this->createCategoryMutationResolver = $createCategoryMutationResolver;
		$this->categoriesQueryResolver = $categoriesQueryResolver;
		$this->user = $user;
	}

	protected function createComponentForm(): CategoryForm
	{
		$form = new CategoryForm();
		$form->onSuccess[] = [$this, 'processForm'];
		$form->onValidate[] = [$this, 'validateSignInForm'];
		return $form;
	}

	public function processForm(CategoryForm $form, CategoryFormValues $values): void
	{
		// Get Identity
		$userId = $this->user->getIdentity()->getId();

		$values = $values->toArray();
		$values["user"] = $userId;

		$request = CreateCategoryRequest::fromArray( $values );
		$this->createCategoryMutationResolver->resolveCreateCategory( $request );
		$this->onCreate();
	}

	public function validateSignInForm(CategoryForm $form, \stdClass $data): void
	{
		// check if sourceUrl is unique
		$categorySlugExistsRequest = new CategoryRequest();
		$categorySlugExistsRequest->setSlug($data->slug);
		$categorySlugExistsCount = $this->categoriesQueryResolver->resolveCategories($categorySlugExistsRequest);

		if( count($categorySlugExistsCount) > 0){
			$form->addError('Slug "' . $data->slug . '" je už obsazený.');
		}

	}

	public function render(): void
	{
		$this->getTemplate()->setFile(__DIR__ . '/templates/createCategory.latte');
		$this->getTemplate()->render();
	}

}
