<?php declare(strict_types = 1);

namespace App\Module\Admin\Url\Component\UrlForm;

use Nette\Application\UI\Control;

final class UrlFormValues extends Control
{

	public string $sourceUrl;
	public string $destinationUrl;
	public string $title;
	public string $comment;
	public int $category;

	/**
	 * @return array{
	 * sourceUrl: string,
	 * destinationUrl: string,
	 * title: string,
	 * comment: string,
	 * category: int,
	 * } $data
	 */
	public function toArray(): array
	{
		return [
			"sourceUrl" => $this->sourceUrl,
			"destinationUrl" => $this->destinationUrl,
			"title" => $this->title,
			"comment" => $this->comment,
			"category" => $this->category,
		];
	}

}
