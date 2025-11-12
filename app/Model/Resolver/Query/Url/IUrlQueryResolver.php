<?php declare(strict_types = 1);

namespace App\Model\Resolver\Query\Url;

use App\Model\Database\Entity\Url;
use App\Model\Resolver\IResolver;
use App\Model\Type\InputObjectType\Url\UrlFilterRequest;

interface IUrlQueryResolver extends IResolver
{

	public function resolveUrl(UrlFilterRequest $request): ?Url;

	public function resolveUpdateUrl(UrlFilterRequest $request): ?int;

}
