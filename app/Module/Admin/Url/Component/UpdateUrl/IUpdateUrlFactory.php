<?php declare(strict_types = 1);

namespace App\Module\Admin\Url\Component\UpdateUrl;

use App\Model\Database\Entity\Url;

interface IUpdateUrlFactory
{

	public function create(Url $url): UpdateUrl;

}
