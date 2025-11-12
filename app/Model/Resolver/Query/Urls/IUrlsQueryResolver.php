<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Urls;

use App\Model\Database\Entity\Url;
use App\Model\Resolver\IResolver;
use App\Model\Type\InputObjectType\Urls\UrlsFilterRequest;

interface IUrlsQueryResolver extends IResolver
{

	/**
	 * @return array<int, Url>
	 */
	public function resolveUrls(UrlsFilterRequest $request): array;

	/**
	 * @return array<int, Url>
	 */
	public function resolveCountUrls(UrlsFilterRequest $request): array;

	public function resolveSumUrl(UrlsFilterRequest $request): ?string;

}
