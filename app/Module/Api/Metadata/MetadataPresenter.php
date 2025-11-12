<?php declare(strict_types = 1);

namespace App\Module\Api\Metadata;

use Nette\Application\UI\Presenter;

final class MetadataPresenter extends Presenter
{

	public function actionMetadata(): void
	{
		$file = __DIR__ . "/resources/openApi.json";

		$data = \Nette\Utils\FileSystem::read($file);
		$this->sendJson($data);

	}

}
