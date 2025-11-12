<?php declare(strict_types = 1);

namespace App\Module\Admin\Category\Component\UpdateCategory;

use App\Model\Database\Entity\Category;
use App\Model\Resolver\Mutation\Category\IUpdateCategoryMutationResolver;
use App\Model\Resolver\Query\Categories\ICategoriesQueryResolver;
use App\Model\Type\InputObjectType\Category\CategoryRequest;
use App\Model\Type\InputObjectType\Category\UpdateCategoryRequest;
use App\Module\Admin\Category\Component\CategoryForm\CategoryForm;
use App\Module\Admin\Category\Component\CategoryForm\CategoryFormValues;
use Nette\Application\UI\Control;

final class UpdateCategory extends Control
{

	/** @var array<int, callable> */
	public array $onUpdate = [];
	private Category $category;
	private IUpdateCategoryMutationResolver $updateCategoryMutationResolver;
	private ICategoriesQueryResolver $categoriesQueryResolver;

	public function __construct(
		Category $category,
		IUpdateCategoryMutationResolver $updateCategoryMutationResolver,
		ICategoriesQueryResolver $categoriesQueryResolver,
	)
	{
		$this->category = $category;
		$this->updateCategoryMutationResolver = $updateCategoryMutationResolver;
		$this->categoriesQueryResolver = $categoriesQueryResolver;
	}

	protected function createComponentForm(): CategoryForm
	{
		$form = new CategoryForm();
		$form->onRender[] = [$this, 'fillForm'];
		$form->onSuccess[] = [$this, 'processForm'];
		$form->onValidate[] = [$this, 'validateSignInForm'];
		return $form;
	}

	public function fillForm(CategoryForm $form): void
	{
		$form->setDefaults([
			'title' => $this->category->getTitle(),
			'slug' => $this->category->getSlug(),
		]);
	}

	public function processForm(CategoryForm $form, CategoryFormValues $values): void
	{
		$request = UpdateCategoryRequest::fromArray( $values->toArray() );
		$this->updateCategoryMutationResolver->resolveUpdateCategory( $this->category, $request );
		$this->onUpdate();

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
		$this->getTemplate()->setFile(__DIR__ . '/templates/updateCategory.latte');
		$this->getTemplate()->render();
	}

}
