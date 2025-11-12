<?php declare(strict_types = 1);

namespace App\Module\Admin\Url\Component\UrlForm;

use App\Model\Resolver\Query\Categories\ICategoriesQueryResolver;
use App\Model\Type\InputObjectType\Category\CategoryRequest;
use Nette\Application\UI\Form;
use Nette\Security\User;

final class UrlForm extends Form
{

	private ICategoriesQueryResolver $categoriesQueryResolver;
	private User $user;

	public function __construct(ICategoriesQueryResolver $categoriesQueryResolver, ?User $user = null)
	{
		parent::__construct();
		$this->categoriesQueryResolver = $categoriesQueryResolver;
		$this->user = $user;

		$this->addText('sourceUrl')
			->setRequired(true);

		$this->addText('destinationUrl')
			->setRequired(true);

		$this->addText('title')
			->setRequired(true);

		$this->addText('comment');

		$request = new CategoryRequest();
		$request->setUserId( $this->user->getId() );
		$categories = $this->categoriesQueryResolver->resolveCategories($request);
		$list = [];

		foreach ($categories as $category) {
			$list[$category->getId()] = $category->getTitle();
		}

		if(count($list) == 0 ){
			$list[0] = "-";
		}

		$this->addSelect('category', 'Kategorie', $list);

		$this->addSubmit('send');

	}

}
